<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    public $increments = false;
    protected $fillable = ['privilege_id', 'privilege'];
}
