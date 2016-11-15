<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    public $incrementing = false;
    public $primaryKey = 'disease_id';
    protected $fillable = ['disease_id', 'disease_name', 'type_of_disease'];
}
