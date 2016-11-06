<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'privilege_id';
    protected $fillable = ['privilege_id', 'privilege_name'];
}
