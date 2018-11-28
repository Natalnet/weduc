<?php

namespace App\Http\Controllers;

use App\Program;
use App\ProgrammingLanguage;
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
        TargetCompiler::compile($program);

        $language = $program->language;

        $origin = "".$language->getFirstMedia('send')->getPath();
        $dest = '../storage/app/program_files/'.$program->id.'/sending';


        // Compilação na linguagem alvo:

        // Remove (se existir) e cria a pasta temporária
        shell_exec("rm -R ".$dest);
        shell_exec("mkdir ".$dest);

        //Extrai o pacote default na pasta
        shell_exec("unzip ".$origin." -d ".$dest);
        shell_exec("unzip ../storage/app/default_files/weducClient.zip -d ".$dest);

        //Copia as classes Java default na pasta
        shell_exec("cp ../storage/app/default_files/HttpDownloadUtility.java ".$dest."/HttpDownloadUtility.java");
        shell_exec("cp ../storage/app/default_files/WeducClient.java ".$dest."/WeducClient.java");

        //read the entire string
        $weducClient=file_get_contents($dest."/WeducClient.java");

        //replace something in the file string
        $weducClient=str_replace('$LINGUAGEM', $language->id, $weducClient);

        $programDownloadUrl = url('/program/'.$program->id.'/download');
        $weducClient=str_replace('$DOWNLOAD_URL', $programDownloadUrl, $weducClient);

        $jsscDownloadUrl = url('/program/'.$program->id.'/download/jssc');
        $weducClient=str_replace('$JSSC_DOWNLOAD_URL', $jsscDownloadUrl, $weducClient);

        $languageFilesDownloadUrl = url('/download/envio/linguagem/'.$language->id);
        $weducClient=str_replace('$LANGUAGE_FILES_URL', $languageFilesDownloadUrl, $weducClient);

        $sendCode = $language->send_code;
        $sendCode = str_replace("nomedoprograma", $program->name, $sendCode);
        $weducClient=str_replace('$SEND_CODE', $sendCode, $weducClient);

        //write the entire string
        file_put_contents($dest."/WeducClient.java", $weducClient);

        $command = "cd ".$dest;
        $command .= " && /usr/bin/javac *.java -classpath jssc.jar";
        $command .= " && /usr/bin/jar vcfm ".$program->name.".jar manifest.mf *.class";

        Storage::disk('program_files')->put($program->id.'/sending/execution.sh', $command);

        exec('/bin/bash '.$dest.'/execution.sh');

        return response()->download($dest.'/'.$program->name.'.jar');
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
