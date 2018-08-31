<?php

namespace App\Listeners;

use App\CompilationLog;
use App\Events\ProgramCompiled;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogCompilation
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ProgramCompiled  $event
     * @return void
     */
    public function handle(ProgramCompiled $event)
    {
        $log = new CompilationLog();
        $log->user_id = auth()->id();
        $log->program_id = $event->program->id;
        $log->exception = $event->exception ? get_class($event->exception) : null;
        $log->is_successful = $event->exception ? true : false;
        $log->save();
    }
}
