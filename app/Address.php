<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
		use WordsTrait;

    public $incrementing = false;
    protected $primaryKey = 'address_id';
    protected $fillable =['address_id', 'postal_code', 'settlement', 'municipality', 'federal_entity_id'];

    public function federalEntity() {
    	return $this->belongsTo(FederalEntity::class, 'federal_entity_id');
    }

  	public function generatePK() {
  		$this->address_id = $this->postal_code . '-' . $this->getCharsFromWords($this->settlement);
  		return $this->address_id;
  	}
}
