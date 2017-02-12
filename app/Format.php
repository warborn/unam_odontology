<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Format extends Model
{
    use PaginateTrait;

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

    public function scopeFromClinic($query, $clinic) {
        return $query->where('formats.clinic_id', $clinic->clinic_id);
    }

    public function has_student(Student $student) {
        return \DB::table('format_student')
            ->where('format_id', $this->format_id)
            ->where('user_id', $student->user_id)
            ->count() > 0;
    }

    public function scopeSearch($query, $term)
    {
        $term = trim($term);
        return $query->join('personal_informations AS intern', 'intern.user_id', '=', 'formats.user_intern_id')
                     ->join('personal_informations AS patient', 'patient.user_id', '=', 'formats.user_patient_id')
                     ->where(function($query) use($term) {
                        $query->where('formats.format_id', $term)
                              ->orWhere(\DB::raw('CONCAT_WS(" ", intern.name, intern.last_name, intern.mother_last_name)'), 'like', "%{$term}%")
                              ->orWhere(\DB::raw('CONCAT_WS(" ", patient.name, patient.last_name, patient.mother_last_name)'), 'like', "%{$term}%");
                     });
    }

    public function scopeBetween($query, $start_date, $end_date)
    {
        return $query->whereBetween('formats.fill_datetime', [$start_date, $end_date]);
    }
}

