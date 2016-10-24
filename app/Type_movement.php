<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type_movement extends Model
{
    public $increments = false;
    protected $fillable = ['type_movement_id', 'description_type_movement'];
}
