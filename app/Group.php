<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public $incrments = false;
    protected $fillable = ['group_id'];
}
