<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InactiveAccount extends Model
{
		public $incrementing = false;
    public $primaryKey = 'account_id';
    protected $fillable = ['account_id', 'status', 'reason'];
}
