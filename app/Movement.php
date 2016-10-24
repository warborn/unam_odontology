<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    public $increments = false;
    protected $fillable = ['date_hour_movement', 'clinic_role_user_id', 'user_id', 'ip', 'type_movement_id'];
}
