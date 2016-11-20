<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public $incrementing = false;
    public $primaryKey = 'user_id';
    protected $fillable = ['user_id', 'account_number'];

    public function user() {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function courses() {
    	return $this->belongsToMany(Course::class, 'course_student', 'user_id', 'course_id')
        ->withPivot('status')
        ->withTimestamps();
    }

    public function formats(){
        return $this->belongsToMany(Format::class, 'format_student', 'user_id', 'format_id')
        ->withTimestamps();
    }
}
