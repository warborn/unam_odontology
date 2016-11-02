<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Format extends Model
{
    public $incrementing = false;
    public $primaryKey = ['format_id'];
    protected $fillable = ['format_id', 'user_intern_id', 'user_intern_id', 'clinic_id', 'user_patient_id', 'medical_history_number', 'hour_data_fill', 'reason_consultation', 'disease', 'general_disease', 'other_disease', 'medical_treatment', 'therapeutic_used', 'observations', 'referred_by', 'dental_disease', 'format_status'];

    public function intern(){
        return $this->belongsTo(Intern::class, 'user_intern_id', 'user_id');
    }

    public function patient(){
        return $this->belongsTo(Patient::class, 'user_patient_id', 'user_id');
    }

    public function clinic(){
        return $this->belongsTo(Clinic::class, 'clinic_id');
    }

    public function general_disease(){
        return $this->belongsTo(Disease::class, 'general_disease', 'disease_id');
    }

    public function dental_disease(){
        return $this->belongsTo(Disease::class, 'dental_disease', 'disease_id');
    }

    public function students(){
        return $this->belongsToMany(Student::class, 'format_student', 'format_id', 'user_id');
    }

    public function courses(){
        return $this->belongsToMany(Course::class, 'format_student', 'format_id', 'group_period_subject_id');
    }
}

