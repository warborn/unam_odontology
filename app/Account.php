<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public $incrementing = false;
    public $primaryKey = 'account_id';
    protected $fillable = ['account_id', 'user_id', 'clinic_id'];

    public function inactiveAccount() {
    	return $this->hasOne(InactiveAccount::class, 'account_id');
    }

    public function isActive() {
    	return $this->inactiveAccount == null ? true : false;
    }

    public function clinic() {
    	return $this->belongsTo(Clinic::class, 'clinic_id');
    }

    public function roles() {
    	return $this->belongsToMany(Role::class, 'account_role', 'account_id', 'role_id');
    }

    public function disabledPrivileges() {
    	return $this->belongsToMany(Privilege::class, 'disabled_privileges', 'account_id', 'privilege_id');
    }
}
