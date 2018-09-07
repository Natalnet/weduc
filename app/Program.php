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

    /**
     * Scope a query to only include programs of a specific language.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \App\ProgrammingLanguage
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfLanguage($query, ProgrammingLanguage $language)
    {
        return $query->where('programming_language_id', $language->id);
    }
}
