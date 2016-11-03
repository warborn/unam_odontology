<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Intern extends Model
{
    public $incrementing = false;
    public $primaryKey = 'user_id';
    protected $fillable = ['user_id', 'service_start_date', 'service_end_date', 'account_number'];

    public function user() {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function formats(){
    	return $this->hasMany(Format::class, 'user_intern_id', 'user_id');
    }

}
