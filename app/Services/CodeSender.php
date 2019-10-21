<?php

namespace App\Services;


use App\Program;
use Illuminate\Support\Facades\Storage;

class CodeSender
{
    private $program;

    private $origin;

    private $destination;

    public function for(Program $program)
    {
        $this->program = $program;
        return $this;
    }

    public function prepare()
    {
        $language = $this->program->language;

        $this->origin = "".$language->getFirstMedia('send')->getPath();
        $this->destination = '../storage/app/program_files/'.$this->program->id.'/sending';

        Storage::disk('program_files')->makeDirectory($this->program->id.'/sending');

        $this->handleDefaultFiles();
        $this->handleSubstitutions();

        return $this;
    }

    public function makeClient()
    {
        $command = "cd ".$this->destination;
        $command .= " && /usr/bin/javac *.java -classpath jssc.jar";
        $command .= " && /usr/bin/jar vcfm ".$this->program->name.".jar manifest.mf *.class";

        Storage::disk('program_files')->put($this->program->id.'/sending/execution.sh', $command);

        exec('/bin/bash '.$this->destination.'/execution.sh');

        return $this;
    }

    public function senderPath()
    {
        return $this->destination.'/'.$this->program->name.'.jar';
    }

    private function handleDefaultFiles()
    {
        // Remove (se existir) e cria a pasta temporária
        shell_exec("rm -R ".$this->destination);
        shell_exec("mkdir ".$this->destination);

        //Extrai o pacote default na pasta
        shell_exec("unzip ".$this->origin." -d ".$this->destination);
        shell_exec("unzip ../storage/app/default_files/weducClient.zip -d ".$this->destination);

        //Copia as classes Java default na pasta
        shell_exec("cp ../storage/app/default_files/HttpDownloadUtility.java ".$this->destination."/HttpDownloadUtility.java");
        shell_exec("cp ../storage/app/default_files/WeducClient.java ".$this->destination."/WeducClient.java");
    }

    private function handleSubstitutions()
    {
        //read the entire string
        $weducClient = file_get_contents($this->destination."/WeducClient.java");

        //replace something in the file string
        $weducClient = str_replace('$LINGUAGEM', $this->program->language->id, $weducClient);

        $programDownloadUrl = url('/program/'.$this->program->id.'/download');
        $weducClient=str_replace('$DOWNLOAD_URL', $programDownloadUrl, $weducClient);

        $jsscDownloadUrl = url('/program/'.$this->program->id.'/download/jssc');
        $weducClient=str_replace('$JSSC_DOWNLOAD_URL', $jsscDownloadUrl, $weducClient);

        $languageFilesDownloadUrl = url('/download/envio/linguagem/'.$this->program->language->id);
        $weducClient=str_replace('$LANGUAGE_FILES_URL', $languageFilesDownloadUrl, $weducClient);

        $sendCode = $this->program->language->send_code;
        $sendCode = str_replace("nomedoprograma", $this->program->name, $sendCode);
        $weducClient = str_replace('$SEND_CODE', $sendCode, $weducClient);

        //write the entire string
        file_put_contents($this->destination."/WeducClient.java", $weducClient);
    }
}
