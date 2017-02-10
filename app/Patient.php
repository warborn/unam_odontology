<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use AccountTrait;
    
    public $incrementing = false;
    public $primaryKey = 'user_id';
    protected $fillable=['age', 'ocupation', 'school_grade', 'civil_status', 'phone', 'has_medical_service', 'medical_service', 'other_medical_service'];

    public function user() {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function federalEntity() {
    	return $this->belongsto(FederalEntity::class, 'federal_entity_id');
    }

    public function format(){
        return $this->hasOne(Format::class, 'user_patient_id', 'user_id');
    }
    
    public function personal_information() {
        return $this->hasOne(PersonalInformation::class, 'user_id');
    }
}
