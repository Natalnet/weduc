<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function languages()
    {
        return $this->hasMany('App\ProgrammingLanguage');
    }

    public function programs()
    {
        return $this->hasMany('App\Program');
    }

    public function coachingClassrooms()
    {
        return $this->hasMany('App\Classroom', 'coach_id');
    }

    public function classrooms()
    {
        return $this->belongsToMany('App\Classroom', 'classroom_student', 'student_id', 'classroom_id');
    }
}
