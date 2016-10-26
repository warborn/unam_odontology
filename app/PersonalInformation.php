<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalInformation extends Model
{
	public $incrementing = false;
	protected $fillable = ['user_id', 'user_name', 'last_name', 'mother_last_name', 'email', 'phone', 'gender', 'address_id', 'street'];
}
