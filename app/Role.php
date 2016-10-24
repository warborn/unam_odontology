<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $increments = false;
    protected $fillable = ['role_id', 'role_description'];
}
