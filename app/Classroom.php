<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    public function coach()
    {
        return $this->belongsTo('App\User', 'coach_id');
    }

    public function students()
    {
        return $this->belongsToMany('App\User', 'classroom_student', 'classroom_id', 'student_id');
    }
}
