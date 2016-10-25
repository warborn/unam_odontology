<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    public $incrementing = false;
    protected $fillable = ['user_id', 'rfc'];
}
