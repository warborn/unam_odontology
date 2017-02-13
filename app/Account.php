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

    public function get_role_id_from($role_value) 
    {
        if(is_object($role_value)) {
            return $role_value->role_id;
        }
        return $this->get_role_id($role_value);
    }

    public function has_role($role_value) {
        $role_id = $this->get_role_id_from($role_value);
        return $this->roles->pluck('role_id', 'role_name')->contains($role_id);
    }

    public function get_role_id($role_alias) {
        return config('constants.id.' . $role_alias);
    }

    public function has_profile($role_value) {
        $role_id = $this->get_role_id_from($role_value);
        switch($role_id) {
            case $this->get_role_id('teacher'):
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
    public function assign_profile($role_value) {
        $role_id = $this->get_role_id_from($role_value);
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
                return ['privilege_id' => $key, 'privilege_name' => $privilege_name, 'status' => $status];
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

    // Get the roles an account can assign or eliminate from another account
    public function enabled_role_privileges($type) 
    {
        return Role::all()->filter(function($role) use ($type) {
            return $this->allow_role_action($type, $role);
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
        return $query->where('accounts.user_id', 'NOT LIKE', '_PAS_%');
    }

    public function scopeActivated($query)
    {
        return $query->join('users', 'users.user_id', '=', 'accounts.user_id')->where('users.activated', true)->select('accounts.*');
    }

    public function scopeActive($query)
    {
        return $query->leftJoin('inactive_accounts', 'inactive_accounts.account_id', '=', 'accounts.account_id')
                     ->whereNull('inactive_accounts.account_id')->select('accounts.*');
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

    // Check if account has privilege to assisn or eliminate role from another account
    public function allow_role_action($type, $role) 
    {
        return $this->allow_action($type . '.' . $this->map_role_alias($role));
    }

    public function get_catalog_privileges($catalog_name) 
    {
        return collect(config('constants.' . $catalog_name))
              ->filter(function($privilege_id, $action) use($catalog_name) { 
                    return $this->allow_action($catalog_name . '.' . $action); 
        })->toArray();
    }

    public function can_action_over($another_account) {
        return !$another_account->has_role('super_user') || ($another_account->has_role('super_user') && account()->has_role('super_user'));
    }

    public function get_action_by_role($type, $role) {
        return 'role.' . $type . '.' . $this->map_role_alias($role); 
    }

    // Map role id with the corresponding role alias
    // ['SPEUAR' => 'super_user']
    private function map_role_alias($role) {
        $role_constants = [$this->get_role_id('super_user') => 'super_user',
            $this->get_role_id('administrator') => 'administrator',
            $this->get_role_id('teacher') => 'teacher',
            $this->get_role_id('intern') => 'intern',
            $this->get_role_id('student') => 'student'];
        return $role_constants[$role->role_id];
    }
}
