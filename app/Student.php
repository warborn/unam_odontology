<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public $increments = false;
    protected $fillable = ['user_id', 'account_number'];
}
