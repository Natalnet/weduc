<?php

namespace App\Services;

use App\Program;
use App\ProgrammingLanguage;
use Illuminate\Support\Facades\Storage;

class TargetCompiler
{
    public static function compile(Program $program)
    {
        self::createTargetCodeFile($program);

        $script = self::prepareCompilationScript($program);

        $makeCommand = "/bin/bash ".$script;

        // Iniciei a compilacao na linguagem
        exec($makeCommand, $output, $returnVar);

        abort_unless($returnVar == 0, 400, implode("\n", $output));
    }

    private static function getCompilerPath(ProgrammingLanguage $language)
    {
        return '../storage/app/language_files/'.$language->getFirstMedia('compile')->id;
    }

    private static function getDestinationPath(Program $program)
    {
        return '../storage/app/program_files/'.$program->id.'/compilation/'.$program->name;
    }

    private static function clearDestination($path)
    {
        shell_exec("rm -R ".$path);
        shell_exec("mkdir -p ".$path);
    }

    private static function prepareCompilationScript(Program $program)
    {
        $command = $program->language->compile_code;
        $dest_path = self::getDestinationPath($program);
        $compiler_path = self::getCompilerPath($program->language);

        $search = ['diretorio', 'localdocompilador', 'nomedoprograma'];
        $replace = [$dest_path, $compiler_path, $program->name];

        $command = str_replace($search, $replace, $command);

        Storage::disk('program_files')->put($program->id.'/compilation/'.$program->name.'/'.'weduc.sh', $command);

        return $dest_path."/weduc.sh";
    }

    /**
     * @param Program $program
     */
    public static function createTargetCodeFile(Program $program): void
    {
        $code = $program->custom_code;
        $language = $program->language;

        $dest = self::getDestinationPath($program);

        self::clearDestination($dest);

        Storage::disk('program_files')->put($program->id . '/compilation/' . $program->name . '/' . $program->name . '.' . $language->extension, $code);
    }
}
