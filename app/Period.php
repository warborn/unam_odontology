<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    public $incrementing = false;
    public $primaryKey = 'period_id';
    protected $fillable = ['period_id', 'period_start_date', 'period_end_date'];

    public function subjects() {
    	return $this->belongsToMany(Subject::class, 'group_period_subject', 'period_id')
    			->withPivot('group_period_subject_id', 'group_id')->withTimestamps();
    }
}
