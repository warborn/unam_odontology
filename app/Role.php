<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
		use WordsTrait;
		
    public $incrementing = false;
    public $primaryKey = 'role_id';
    protected $fillable = ['role_name', 'role_description'];

    public function privileges() {
    	return $this->belongsToMany(Privilege::class, 'privilege_role', 'role_id', 'privilege_id')
    		->withTimestamps()->orderBy('privilege_name');
    }

    public function generatePK() {
    	$this->role_id = $this->getCharsFromWords($this->role_name);
    	return $this->role_id;
    }

    public function scopeName($query, $role_name) {
        return $this->where('role_name', $role_name)->first();
    }
}
