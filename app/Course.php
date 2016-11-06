<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'course_id';

    public function students(){
        return $this->belongsToMany(Student::class, 'course_student', 'course_id', 'user_id')
        ->withTimestamps();
    }
}
