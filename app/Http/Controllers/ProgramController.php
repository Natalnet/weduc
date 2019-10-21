<?php

namespace App\Http\Controllers;

use App\Program;
use App\ProgrammingLanguage;
use App\Services\CodeSender;
use App\Services\TargetCompiler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Natalnet\Relex\FunctionSymbol;
use Natalnet\Relex\ReducLexer;
use Natalnet\Relex\ReducParser;
use Natalnet\Relex\Translator\Translator;
use Natalnet\Relex\Types;

class ProgramController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['downloadSendZip', 'downloadProgram', 'downloadJssc']);
    }

    public function program()
    {
        // return ProgrammingLanguage::pluck('name', 'id')->toJson();
        return view('program')->with([
            'languages' => ProgrammingLanguage::all(),
            'functions' => ProgrammingLanguage::all()->first()->functions()->get(),
            'test' => ProgrammingLanguage::pluck('name', 'id')->toJson()
        ]);
    }

    public function language($id)
    {
        return ProgrammingLanguage::with('functions')
                                  ->with(['programs' => function ($query) {
                                      $query->where('user_id', auth()->user() ? auth()->user()->id : '');
                                  }])
                                  ->find($id);
    }

    public function compile(Request $request)
    {
        try {
            $lexer = new ReducLexer($request->code);
            $parser = new ReducParser($lexer);

            $language = ProgrammingLanguage::with('functions')->find($request->language);

            foreach ($language->functions as $function) {
                $parameters = [];
                preg_match_all('/var[1-9]+\(([a-zA-Z]+)\)/', $function->code, $matches);
                for ($i = 0; $i < count($matches[1]); $i++) {
                    switch ($matches[1][$i]) {
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
        } catch (\Exception $e) {
            // report($e);
            return response()->json([
                'compiled' => false,
                'errors' => [
                    'message' => $e->getMessage()
                ]
            ], 422);
        }
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
            ReducLexer::T_E => $language->operators->logical_and,
            ReducLexer::T_OU => $language->operators->logical_or,
            ReducLexer::T_NEGATE => $language->operators->logical_not,
            ReducLexer::T_EQUALS_EQUALS => $language->operators->equals_to,
            ReducLexer::T_NOT_EQUAL => $language->operators->not_equal_to,
            ReducLexer::T_LESS_THAN => $language->operators->less_than,
            ReducLexer::T_GREATER_THAN => $language->operators->greater_than,
            ReducLexer::T_LESS_THAN_EQUAL => $language->operators->less_than_or_equals_to,
            ReducLexer::T_GREATER_THAN_EQUAL => $language->operators->greater_than_or_equals_to,
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
        // $trans->translate();
        $trans->translate();
        return [
            'compiled' => true,
            'translatedCode' => $language->header . $trans->getTranslation()
        ];
    }

    public function translate()
    {
        $str = "
        inicio
            se (verdadeiro) entao {

            }
        fim
        ";
        $lexer = new ReducLexer($str);
        $parser = new ReducParser($lexer);
        $parser->program();
        $program = $parser->parseTree->getNode();
        foreach ($program->getChildren() as $node) {
            if ($node->getValue() == 'commands') {
                foreach ($node->getChildren() as $child) {
                    echo $node->getValue();
                }
            } else {
                echo $node->getValue();
            }
        }
        // dd();
        // return $str;
    }

    public function compileTarget(Program $program)
    {
        TargetCompiler::compile($program);

        return response(null, 204);
    }

    public function downloadSendZip(ProgrammingLanguage $language)
    {
        return response()->download($language->getFirstMedia('send')->getPath(), $language->id.'.zip');
    }

    public function downloadProgram(Program $program)
    {
        if ($program->language->compile_code === null) {
            TargetCompiler::createTargetCodeFile($program);
        }

        $fileName = $program->language->sent_extension;
        $fileName = str_replace("nomedoprograma", $program->name, $fileName);
        $filePath = '../storage/app/program_files/'.$program->id.'/compilation/'.$program->name.'/'.$fileName;
        return response()->download($filePath);
    }

    public function downloadJssc(Program $program)
    {
        $filePath = '../storage/app/program_files/'.$program->id.'/sending/jssc.jar';
        return response()->download($filePath);
    }

    public function sendCode(Program $program)
    {
        TargetCompiler::createTargetCodeFile($program);

        $codeSender = (new CodeSender())->for($program)->prepare()->makeClient();

        return response()->download($codeSender->senderPath());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $language = ProgrammingLanguage::find($request->language);
        $program = new Program();
        $program->user_id = auth()->user()->id;
        $program->name = $request->name;
        $program->reduc_code = $request->code;
        $program->custom_code = $request->custom_code;

        return $language->programs()->save($program);
    }

    public function update(Request $request, Program $program)
    {
        // return $request;
        $program->reduc_code = $request->code;
        $program->custom_code = $request->custom_code;
        $program->save();
    }
}
