<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use AccountTrait;
    
    public $incrementing = false;
    public $primaryKey = 'user_id';
    protected $fillable = ['user_id', 'account_number'];

    public function user() {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function courses() {
    	return $this->belongsToMany(Course::class, 'course_student', 'user_id', 'course_id')
        ->withPivot('status')
        ->withTimestamps();
    }

    public function course_status($course) {
        if($course->has_student($this)) {
            return $this->courses()->find($course->course_id)->pivot->status;
        } else {
            return null;
        }
    }

    public function formats(){
        return $this->belongsToMany(Format::class, 'format_student', 'user_id', 'format_id')
        ->withTimestamps();
    }
    public function personal_information() {
        return $this->hasOne(PersonalInformation::class, 'user_id');
    }

    public function scopeActivated($query)
    {
        return $query->join('users', 'users.user_id', '=', 'students.user_id')->where('users.activated', true);
    }

    public function scopeFromClinic($query, $clinic) {
         return $query->join('accounts', 'accounts.user_id', '=', 'students.user_id')->where('accounts.clinic_id', $clinic->clinic_id);
    }
}
