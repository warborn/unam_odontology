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

    public function status() {
        if(!$this->isActive()) {
            return $this->inactiveAccount->status;
        } else {
            return null;
        }
    }

    public function clinic() {
    	return $this->belongsTo(Clinic::class, 'clinic_id');
    }

    public function roles() {
    	return $this->belongsToMany(Role::class, 'account_role', 'account_id', 'role_id')
            ->withTimestamps();
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function all_privileges() {
        $disabled_privileges = $this->disabledPrivileges->pluck('privilege_name', 'privilege_id');
        return $this->roles->map(function($role) { 
                return $role->privileges->pluck('privilege_name', 'privilege_id'); 
            })->flatten(1)->map(function($privilege_name, $key) use ($disabled_privileges) {
                $status = $disabled_privileges->has($key) == true ? 'disabled' : 'enabled';
                return ['privilege_name' => $privilege_name, 'status' => $status];
            })->toArray();

    }

    public function disabledPrivileges() {
    	return $this->belongsToMany(Privilege::class, 'disabled_privileges', 'account_id', 'privilege_id')
            ->withTimestamps();
    }

    public function generatePK() {
        $this->account_id = $this->user_id . $this->clinic_id;
        return $this->account_id;
    }
}
