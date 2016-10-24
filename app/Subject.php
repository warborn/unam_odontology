<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public $increments = false;
    protected $fillable = ['subject_name_id', 'semester'];
}
