<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public $incrementing = false;
    protected $table = 'group_period_subject';
    protected $primaryKey = 'group_period_subject_id';

    public function formats(){
    	return $this->belongsToMany(Format::class)->withTimestamps();
    }

    public function students(){
        return $this->belongsToMany(Student::class)->withTimestamps();
    }
}
