<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalInformation extends Model
{
	public $incrementing = false;
	public $primaryKey = 'user_id';
	protected $fillable = ['user_id', 'name', 'last_name', 'mother_last_name', 'email', 'phone', 'gender', 'address_id', 'street'];

	public function fullname() {
		return $this->name.' '.$this->last_name.' '.$this->mother_last_name;
	}

	public function address(){
		return $this->hasOne(Address::class, 'address_id');
	}
}
