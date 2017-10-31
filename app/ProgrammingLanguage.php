<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

class ProgrammingLanguage extends Model implements HasMedia
{
    use HasMediaTrait;

    public function dataType()
    {
        return $this->hasOne('App\DataType');
    }

    public function functions()
    {
        return $this->hasMany('App\ReducFunction');
    }

    public function programs()
    {
        return $this->hasMany('App\Program');
    }

    public function controlFlowStatements()
    {
        return $this->hasOne('App\ControlFlow');
    }
}
