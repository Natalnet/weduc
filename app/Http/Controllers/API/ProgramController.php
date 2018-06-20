<?php

namespace App\Http\Controllers\API;

use App\Program;
use App\ProgrammingLanguage;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

    public function indexForUser(User $user)
    {
        return $user->programs;
    }

    public function store(Request $request)
    {
        $request->validate([
            'target_language' => 'required|exists:programming_languages,id',
            'name' => 'required',
            'reduc_code' => 'required_without:custom_code|required_if:custom_code,null',
            'custom_code' => 'required_if:reduc_code,null',
        ]);

        $language = ProgrammingLanguage::findOrFail($request->target_language);
        $program = new Program();
        $program->user_id = 1; //auth()->user()->id;
        $program->name = $request->name;
        $program->reduc_code = $request->reduc_code;
        $program->custom_code = $request->custom_code;

        return $language->programs()->save($program);
    }

    public function compile(Request $request, Program $program)
    {
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
            $statements = [
                'ifStatement' => $controlFlow->if_code,
                'repeatStatement' => $controlFlow->repeat_code,
                'whileStatement' => $controlFlow->while_code
            ];
            //$trans->setControlFlowStatements($statements);
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
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'The compilation failed.',
                'errors' => [
                    'reduc_code' => [
                        'line' => 1,
                        'message' => $e->getMessage()
                    ]
                ]
            ], 422);
        }

        return [
            'success' => true,
            'target_code' => $program->custom_code
        ];
    }

    protected function getFunctionParams($functionCode)
    {
        $parameters = [];
        preg_match_all('/var[1-9]+\(([a-zA-Z]+)\)/', $functionCode, $matches);
        foreach ($matches[1] as $parameterType) {
            switch ($parameterType) {
                case 'int':
                    $parameters[] = Types::NUMBER_TYPE;
                    break;
                case 'String':
                    $parameters[] = Types::STRING_TYPE;
                    break;
                case 'boolean':
                    $parameters[] = Types::BOOLEAN_TYPE;
                    break;
            }
        }

        return $parameters;
    }
}
