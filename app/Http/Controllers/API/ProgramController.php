<?php

namespace App\Http\Controllers\API;

use App\Events\ProgramCompiled;
use App\Program;
use App\ProgrammingLanguage;
use App\Services\CodeSender;
use App\Services\TargetCompiler;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Natalnet\Relex\Exceptions\InvalidCharacterException;
use Natalnet\Relex\Exceptions\SymbolNotDefinedException;
use Natalnet\Relex\Exceptions\TypeMismatchException;
use Natalnet\Relex\Exceptions\UnexpectedTokenException;
use Natalnet\Relex\FunctionSymbol;
use Natalnet\Relex\ReducLexer;
use Natalnet\Relex\ReducParser;
use Natalnet\Relex\Translator\Translator;
use Natalnet\Relex\Types;

class ProgramController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function indexForCurrentUser()
    {
        return auth()->user()->programs;
    }

    public function indexForCurrentUserAndLanguage(ProgrammingLanguage $language)
    {
        return auth()->user()->programs()->ofLanguage($language)->get();
    }

    public function indexForUser(User $user)
    {
        return $user->programs;
    }

    public function store(Request $request)
    {
        $request->validate([
            'target_language_id' => 'required|exists:programming_languages,id',
            'name' => [
                'required',
                Rule::unique('programs')->where(function ($query) {
                    return $query->where('user_id', auth()->id());
                })
            ],
            'reduc_code' => 'required_without:target_code|required_if:target_code,null',
            'target_code' => 'required_if:reduc_code,null',
        ]);

        $language = ProgrammingLanguage::findOrFail($request->target_language_id);
        $program = new Program();
        $program->user_id = auth()->user()->id;
        $program->name = $request->name;
        $program->reduc_code = $request->reduc_code;
        $program->custom_code = $request->target_code;

        return $language->programs()->save($program);
    }

    public function update(Request $request, Program $program)
    {
        $request->validate([
            'name' => 'required',
            'reduc_code' => 'required_without:target_code|required_if:target_code,null',
            'target_code' => 'required_if:reduc_code,null',
        ]);

        $program->name = $request->name;
        $program->reduc_code = $request->reduc_code;
        if ($program->reduc_code === null)
        {
            $program->custom_code = $request->target_code;
        }
        $program->save();

        return response(null, 204);
    }

    public function compile(Request $request, Program $program)
    {
        $started_at = Carbon::now()->toDateTimeString();

        try {
            // Create a new Redux Lexer from the code to be compiled
            $lexer = new ReducLexer($program->reduc_code);

            // Use the Lexer to generate an Reduc Parser
            $parser = new ReducParser($lexer);

            $language = $program->language;

            // Loop through each language function and define its corresponding symbol in the parser
            foreach ($language->functions as $function) {
                $parameters = $this->getFunctionParams($function->code);

                $returnType = null;
                switch ($function->return_type) {
                    case 'float':
                        $returnType = Types::NUMBER_TYPE;
                        break;
                    case 'String':
                        $returnType = Types::STRING_TYPE;
                        break;
                    case 'boolean':
                        $returnType = Types::BOOLEAN_TYPE;
                        break;
                }

                $parser->symbolTable->define(new FunctionSymbol($function->name, $returnType, $parameters));
            }

            $parser->program();

            $trans = new Translator($parser->parseTree);

            $trans->setMainFunction($language->main_function);
            $trans->setInstructionSeparator(';');
            $controlFlow = $language->controlFlowStatements()->first();

            $trans->setIfStatement($controlFlow->if_code);
            $trans->setElseIfStatement($controlFlow->else_if);
            $trans->setElseStatement($controlFlow->else);
            $trans->setRepeatStatement($controlFlow->repeat_code);
            $trans->setWhileStatement($controlFlow->while_code);
            $trans->setOperators([
                ReducLexer::T_E => '&&',
                ReducLexer::T_OU => '||',
                ReducLexer::T_NEGATE => '!',
                ReducLexer::T_EQUALS_EQUALS => '==',
                ReducLexer::T_NOT_EQUAL => '!=',
                ReducLexer::T_LESS_THAN => '<',
                ReducLexer::T_GREATER_THAN => '>',
                ReducLexer::T_LESS_THAN_EQUAL => '<=',
                ReducLexer::T_GREATER_THAN_EQUAL => '>=',
            ]);

            $trans->setVariableDeclarations([
                Types::NUMBER_TYPE => $language->getDataType('declare_float'),
                Types::STRING_TYPE => $language->getDataType('declare_string'),
                Types::BOOLEAN_TYPE => $language->getDataType('declare_boolean'),
            ]);

            $functions = [];
            foreach ($language->functions as $function) {
                $functions[$function->name] = $function->code;
            }
            $trans->setFunctions($functions);
            $trans->translate();

            $program->custom_code = $language->header . $trans->getTranslation() . $language->footer;
            $program->save();

            event(new ProgramCompiled($program));
        } catch (\Exception $e) {
            if ($e instanceof InvalidCharacterException) {
                $line = $e->codeLine;
                $message = "Caractere inválido: $e->character";
            } elseif ($e instanceof SymbolNotDefinedException) {
                $line = $e->codeLine;
                $message = "Símbolo não definido. Definição não encontrada para '$e->symbolName'";
            } elseif ($e instanceof TypeMismatchException) {
                $line = $e->codeLine;
                $message = "Tipos incompatíveis. Esperado: $e->expectedType, encontrado: $e->foundType";
            } elseif ($e instanceof UnexpectedTokenException) {
                $line = $e->codeLine;
                $message = "Token não esperado. Esperado: $e->expectedToken, encontrado: $e->foundToken";
            } else {
                $line = 0;
                $message = $e->getMessage();
            }

            event(new ProgramCompiled($program, $e));

            return response()->json([
                'message' => 'The compilation failed.',
                'errors' => [
                    'reduc_code' => [
                        'line' => $line,
                        'message' => $message
                    ]
                ],
                'started_at' => $started_at,
                'finished_at' => Carbon::now()
            ], 422);
        }

        return [
            'success' => true,
            'target_code' => $program->custom_code,
            'started_at' => $started_at,
            'finished_at' => Carbon::now()->toDateTimeString()
        ];
    }

    public function compileTarget(Program $program)
    {
        TargetCompiler::compile($program);

        return response(null, 204);
    }

    public function downloadCodeSender(Program $program)
    {
        $codeSender = (new CodeSender())->for($program)->prepare()->makeClient();

        return response()->download($codeSender->senderPath());
    }

    protected function getFunctionParams($functionCode)
    {
        $parameters = [];
        preg_match_all('/var[1-9]+\(([a-zA-Z]+)\)/', $functionCode, $matches);
        foreach (array_combine($matches[0], $matches[1]) as $parameter => $parameterType) {
            switch ($parameterType) {
                case 'int':
                    $parameters[$parameter] = Types::NUMBER_TYPE;
                    break;
                case 'String':
                    $parameters[$parameter] = Types::STRING_TYPE;
                    break;
                case 'boolean':
                    $parameters[$parameter] = Types::BOOLEAN_TYPE;
                    break;
            }
        }

        return array_values($parameters);
    }

    public function destroy(Program $program)
    {
        $program->delete();

        return response(null, 204);
    }
}
