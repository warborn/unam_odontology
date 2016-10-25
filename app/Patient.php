<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    public $incrementing = false;
    protected $fillable=['user_id', 'age', 'federal_entity_id', 'ocupation', 'school_grade', 'civil_status', 'phone', 'service_medical', 'service_name']
}
