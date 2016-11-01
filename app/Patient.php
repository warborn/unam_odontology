<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    public $incrementing = false;
    public $primaryKey = 'user_id';
    protected $fillable=['user_id', 'age', 'federal_entity_id', 'ocupation', 'school_grade', 'civil_status', 'phone', 'service_medical', 'service_name'];

    public function user() {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function federalEntity() {
    	return $this->belongsTo(FederalEntity::class, 'federal_entity_id');
    }
}
