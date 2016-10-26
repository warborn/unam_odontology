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
}
