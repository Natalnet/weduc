<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SBoticsRelease extends Model
{
    protected $guarded = [];

    protected $casts = [
        'released_at' => 'date'
    ];
}
