<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    public $increments = false;
    protected $fillable = ['user_id', 'rfc'];
}
