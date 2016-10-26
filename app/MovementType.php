<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovementType extends Model
{
    public $incrementing = false;
    protected $fillable = ['movement_type_id', 'description_movement_type'];
}
