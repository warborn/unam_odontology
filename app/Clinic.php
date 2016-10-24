<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    public $increments = false;
    protected $fillable = ['clinic_name_id', 'adress_id', 'clinic_email', 'clinic_phone', 'street'];
}
