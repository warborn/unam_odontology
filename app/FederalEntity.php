<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FederalEntity extends Model
{
    public $incrementing = false;
    protected $fillable = ['federal_entity_id'];
}
