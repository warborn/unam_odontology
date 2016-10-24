<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adress extends Model
{
    public $increments = false;
    protected $fillable =['adress_id', 'postal_code', 'settlement', 'municipality', 'federal_entity_id'];
}
