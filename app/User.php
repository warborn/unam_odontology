<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
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

    public function intern() {
        return $this->hasOne(Intern::class, 'user_id');
    }

    public function student() {
        return $this->hasOne(Student::class, 'user_id');
    }

    public function patient() {
        return $this->hasOne(Patient::class, 'user_id');
    }

    public function accounts() {
        return $this->hasMany(Account::class, 'user_id');
    }

    public static function setupAccount($data) {
        $clinic = Clinic::findOrFail($data['clinic_id']);

        $personal_information = new PersonalInformation([
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'mother_last_name' => $data['mother_last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'gender' => $data['gender'],
            'street' => $data['street'],
        ]);

        $user = User::create([
            'user_id' => $data['user_id'],
            'password' => bcrypt($data['password']),
        ]);

        $user->personal_information()->save($personal_information);
        $account = new Account([
            'clinic_id' => $clinic->clinic_id,
            'user_id' => $user->user_id,
        ]);
        $account->generatePK();
        $user->accounts()->save($account);
        return $user;
    }
}
