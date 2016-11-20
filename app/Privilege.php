<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
		use WordsTrait;

    public $incrementing = false;
    protected $primaryKey = 'privilege_id';
    protected $fillable = ['privilege_name'];

    public function generatePK() {
    	$this->privilege_id = $this->getCharsFromWords($this->privilege_name);
    	return $this->privilege_id;
    }
}
