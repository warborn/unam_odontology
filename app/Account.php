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

    public function has_role($role_alias) {
        $role_id = $this->get_role_id($role_alias);
        return $this->roles->pluck('role_id', 'role_name')->contains($role_id);
    }

    public function get_role_id($role_alias) {
        return config('constants.id.' . $role_alias);
    }

    public function has_profile($role_alias) {
        $role_id = $this->get_role_id($role_alias);
        switch($role_id) {
            case get_role_id('teacher'):
                return $this->user->teacher;
                break;
            case $this->get_role_id('student'):
                return $this->user->student;
                break;
            case $this->get_role_id('intern'):
                return $this->user->intern;
                break;
            case $this->get_role_id('super_user'):
            case $this->get_role_id('administrator'):
                return $this->user;
                break;
        }
        return false;
    }

    // assign profile to user based on role
    public function assign_profile($role_id) {
        switch($role_id) {
            case $this->get_role_id('teacher'):
                $this->user->teacher()->save(new Teacher(['user_id' => $this->user_id]));
                break;
            case $this->get_role_id('student'):
                $this->user->student()->save(new Student(['user_id' => $this->user_id]));
                break;
            case $this->get_role_id('intern'):
                $this->user->intern()->save(new Intern(['user_id' => $this->user_id]));
                break;
        }
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

    // Return all the privileges for an account excluding the disabled ones
    public function enabledPrivileges() 
    {
        return $this->join('account_role', 'account_role.account_id', '=', 'accounts.account_id')
                    ->join('roles', 'roles.role_id', '=', 'account_role.role_id')
                    ->join('privilege_role', 'privilege_role.role_id', '=', 'roles.role_id')
                    ->join('privileges', 'privileges.privilege_id', '=', 'privilege_role.privilege_id')
                    ->select('privileges.*')->where('accounts.account_id', '=', $this->account_id)->whereNotIn('privileges.privilege_id', function($query) {
                        $query->select('privilege_id')
                              ->from('disabled_privileges')
                              ->where('account_id', '=', $this->account_id);
                    })->get();
    }

    // Check if the account has an enabled privilege by name
    public function has_privilege($privilege_id)
    {
        return $this->enabledPrivileges()->map(function($privilege) {
            return $privilege->privilege_id;
        })->contains(function($key, $value) use($privilege_id){
            return $value === $privilege_id;
        });
    }

    // Check if account has an enabled privilege based on the action name in form of controller.action, i.e. formats.index
    public function allow_action($action_name)
    {
        return $this->has_privilege(config('constants.' . $action_name));
    }

    public function disabledPrivileges() {
    	return $this->belongsToMany(Privilege::class, 'disabled_privileges', 'account_id', 'privilege_id')
            ->withTimestamps();
    }

    public function generatePK() {
        $this->account_id = $this->user_id . $this->clinic_id;
        return $this->account_id;
    }

    public function scopeFromClinic($query, $clinic) {
        return $query->where('accounts.clinic_id', $clinic->clinic_id);
    }

    public function scopeFrom($query, $user_id, $clinic_id) {
        return $query->where('accounts.account_id', $user_id . $clinic_id)->first();
    }

    public function scopeNotPatient($query) {
        return $query->where('user_id', 'NOT LIKE', '_PAS_%');
    }

    public function scopeActivated($query)
    {
        return $query->join('users', 'users.user_id', '=', 'accounts.user_id')->where('users.activated', true);
    }

    public function is(Account $account)
    {
        return $this->getKey() == $account->getKey();
    }

    public function is_patient()
    {
        return strpos($this->getKey(), '_PAS_') !== false;
    }

    public function destroy_disabled_privileges($role) {
        $privileges = [];
        foreach ($role->privileges as $privilege) {
            $privileges[] = $privilege->privilege_id;    
        }
        $this->disabledPrivileges()->detach($privileges);
    }
}
