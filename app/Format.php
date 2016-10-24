<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Format extends Model
{
    public $increments = false;
    protected $fillable = ['format_id', 'user_intern_id', 'user_intern_id', 'clinic_name_id', 'user_id', 'medical_history', 'hour_data_fill', 'reason_consultation', 'disease_id', 'general_illness', 'other_disease', 'medical_treatment', 'therapeutic_used', 'observations', 'referenced', 'dental_disease', 'format_status'];
}
