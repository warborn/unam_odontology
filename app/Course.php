<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'course_id';
    protected $fillable = ['group_id', 'period_id', 'subject_id'];
    
    public function students(){
        return $this->belongsToMany(Student::class, 'course_student', 'course_id', 'user_id')
        ->withPivot('status')
        ->withTimestamps();
    }
    public function teachers(){
        return $this->belongsToMany(Teacher::class, 'course_teacher', 'course_id', 'user_id')
        ->withTimestamps();
    }
    public function group(){
    	return $this->belongsTo(Group::class, 'group_id');
    }

    public function period(){
    	return $this->belongsTo(Period::class, 'period_id');
    }

    public function subject(){
    	return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function has_teacher($teacher) {
        return $this->teachers()->find($teacher->user_id) != null ? true : false;
    }
    public function generatePK() {
        $this->course_id = $this->group_id . $this->period_id . $this->subject_id;
        return $this->course_id;
    }
}
