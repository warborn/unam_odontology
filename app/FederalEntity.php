<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FederalEntity extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'federal_entity_id';
    protected $fillable = ['federal_entity_id'];

    public function addresses() {
    	return $this->hasMany(Address::class, 'federal_entity_id');
    }
}
