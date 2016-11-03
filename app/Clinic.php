<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'clinic_id';
    protected $fillable = ['clinic_id', 'address_id', 'clinic_email', 'clinic_phone', 'street'];

    public function address() {
    	return $this->belongsTo(Address::class, 'address_id');
    }

    public function formats(){
        return $this->hasMany(Format::class, 'clinic_id');
    }
}
