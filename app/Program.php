<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    /**
     * Get the programming language that owns the program.
     */
    public function language()
    {
        return $this->belongsTo('App\ProgrammingLanguage', 'programming_language_id');
    }
}
