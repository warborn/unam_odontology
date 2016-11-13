<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'course_id';
    protected $fillable = ['course_id', 'group_id', 'period_id', 'subject_id'];
    
    public function students(){
        return $this->belongsToMany(Student::class, 'course_student', 'course_id', 'user_id')
        ->withTimestamps();
    }

    public function groups(){
    	return $this->belongsTo(Group::class, 'group_id');
    }

    public function periods(){
    	return $this->belongsTo(Period::class, 'period_id');
    }

    public function subjects(){
    	return $this->belongsTo(Subject::class, 'subject_id');
    }
}
