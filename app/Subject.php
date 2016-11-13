<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
		use WordsTrait;

    public $incrementing = false;
    public $primaryKey = 'subject_id';
    protected $fillable = ['subject_name', 'semester'];

    public function generatePK() {
    	$this->subject_id = $this->getCharsFromWords($this->subject_name);
    	return $this->subject_id;
    }
}
