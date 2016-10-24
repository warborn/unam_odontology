<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personal_information extends Model
{
	public $increments = false;
	protected $fillable = ['user_id', 'user_name', 'last_name', 'mother_last_name', 'email', 'phone', 'gender', 'adress_id', 'street'];
}
