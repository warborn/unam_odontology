<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    public $increments = false;
    protected $fillable = ['period_id', 'period_start_date', 'period_end_date'];
}
