<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    public $incrementing = false;
    protected $fillable = ['clinic_name_id', 'address_id', 'clinic_email', 'clinic_phone', 'street'];
}
