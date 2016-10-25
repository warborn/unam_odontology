<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $incrementing = false;
    public $primaryKey = 'role_id';
    protected $fillable = ['role_id', 'role_description'];

    public function privileges() {
    	return $this->belongsToMany(Privilege::class, 'privilege_role', 'role_id', 'privilege_id');
    }
}
