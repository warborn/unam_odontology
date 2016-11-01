<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    public $incrementing = false;
    public $primaryKey = 'user_id';
    /**
     * The attributes that are mass assignable.0
     *
     * @var array
     */
    protected $fillable = ['user_id', 'password'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function personal_information() {
        return $this->hasOne(PersonalInformation::class, 'user_id');
    }

    public function teacher() {
        return $this->hasOne(Teacher::class, 'user_id');
    }

    public function student() {
        return $this->hasOne(Student::class, 'user_id');
    }

    public function clinics() {
        return $this->belongsToMany(Clinic::class, 'clinic_role_user', 'user_id');
    }

    public function roles() {
        return $this->belongsToMany(Role::class, 'clinic_role_user', 'user_id')
            ->withPivot('clinic_role_user_id');
    }

    public function genClinicRoleUserPK($clinic, $role) {
        return $this->user_id . $clinic->clinic_id . (isset($role) ? $role->role_id : '');
    }
}
