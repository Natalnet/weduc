<?php

namespace App\Events;

use App\Program;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ProgramCompiled
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $program;
    public $exception;

    /**
     * Create a new event instance.
     *
     * @param \App\Program  $program
     * @param \Exception|null  $exception
     * @return void
     */
    public function __construct(Program $program, \Exception $exception = null)
    {
        $this->program = $program;
        $this->exception = $exception;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
