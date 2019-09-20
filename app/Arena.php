<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Arena extends Model
{
    protected $guarded = [];

    public function usages()
    {
        return $this->hasMany(ArenaUsage::class);
    }
}
