<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public $incrementing = false;
    protected $table = 'group_period_subject';
    protected $primaryKey = 'group_period_subject_id';

    public function students(){
        return $this->belongsToMany(Student::class, 'group_student', 'group_period_subject_id', 'user_id')
        ->withTimestamps();
    }
}
