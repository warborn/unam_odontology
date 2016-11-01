<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public $incrementing = false;
    public $primaryKey = 'subject_id';
    protected $fillable = ['subject_name_id', 'semester'];
}
