<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'address_id';
    protected $fillable =['address_id', 'postal_code', 'settlement', 'municipality', 'federal_entity_id'];
}
