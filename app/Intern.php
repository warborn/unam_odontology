<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Intern extends Model
{
    public $increments = false;
    protected $fillable=['user_id', 'service_start_date', 'service_end_date', 'account_number'];
}
