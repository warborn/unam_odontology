<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public $incrementing = false;
    public $primaryKey = 'group_id';
    protected $fillable = ['group_id'];
}