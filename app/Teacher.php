<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    public $incrementing = false;
    public $primaryKey = 'user_id';
    protected $fillable = ['user_id', 'rfc'];

    public function user() {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function courses() {
    	return $this->belongsToMany(Course::class, 'course_teacher', 'user_id', 'course_id')
    		->withTimestamps();
    }

    public function personal_information() {
        return $this->hasOne(PersonalInformation::class, 'user_id');
    }

}
