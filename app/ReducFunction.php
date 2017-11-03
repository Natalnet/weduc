<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReducFunction extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the programming language that owns the function.
     */
    public function language()
    {
        return $this->belongsTo('App\ProgrammingLanguage', 'programming_language_id');
    }
}
