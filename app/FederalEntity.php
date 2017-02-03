<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FederalEntity extends Model
{
	use WordsTrait;
		
    public $incrementing = false;
    protected $primaryKey = 'federal_entity_id';
    protected $fillable = ['federal_entity_name'];

    public function addresses() {
    	return $this->hasMany(Address::class, 'federal_entity_id');
    }

    public function generatePK() {
    	$this->federal_entity_id = $this->getCharsFromWords($this->federal_entity_name, 3);
    	return $this->federal_entity_id;
    }
}
