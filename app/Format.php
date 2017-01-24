<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Format extends Model
{
    public $incrementing = false;
    public $primaryKey = 'format_id';
    protected $fillable = ['medical_history_number', 'hour_data_fill', 'consultation_reason', 'has_disease', 'other_disease', 'medical_treatment', 'therapeutic_used', 'observations', 'referred_by', 'format_status'];

    public function intern(){
        return $this->belongsTo(Intern::class, 'user_intern_id', 'user_id');
    }

    public function patient(){
        return $this->belongsTo(Patient::class, 'user_patient_id', 'user_id');
    }

    public function clinic(){
        return $this->belongsTo(Clinic::class, 'clinic_id');
    }

    public function generalDisease(){
        return $this->belongsTo(Disease::class, 'general_disease', 'disease_id', 'diseases');
    }

    public function dentalDisease(){
        return $this->belongsTo(Disease::class, 'dental_disease', 'disease_id', 'diseases');
    }

    public function students(){
        return $this->belongsToMany(Student::class, 'format_student', 'format_id', 'user_id')
            ->withPivot('course_id')
            ->withTimestamps();
    }

    public function courses(){
        return $this->belongsToMany(Course::class, 'format_student', 'format_id', 'course_id')
            ->withTimestamps();
    }

    public function generatePK() {
        return $this->format_id = 'F' . array_rand(range(1, 999));
    }

    public function filled_by(Intern $intern) {
        return $this->intern->getKey() == $intern->getKey();
    }
}

