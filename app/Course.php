<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public $incrementing = false;
    protected $table = 'group_period_subject';
    protected $primaryKey = 'group_period_subject_id';
}
