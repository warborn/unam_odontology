<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use PaginateTrait; 
    
    public $incrementing = false;
    protected $primaryKey = 'course_id';
    protected $fillable = ['group_id', 'period_id', 'subject_id'];
    
    public function students(){
        return $this->belongsToMany(Student::class, 'course_student', 'course_id', 'user_id')
        ->withPivot('status')
        ->withTimestamps();
    }
    public function teachers(){
        return $this->belongsToMany(Teacher::class, 'course_teacher', 'course_id', 'user_id')
        ->withTimestamps();
    }
    public function group(){
    	return $this->belongsTo(Group::class, 'group_id');
    }

    public function period(){
    	return $this->belongsTo(Period::class, 'period_id');
    }

    public function subject(){
    	return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function clinic(){
        return $this->belongsTo(Clinic::class, 'clinic_id');
    }

    public function has_student($student) {
        return $this->students()->find($student->user_id) != null ? true : false;
    }

    public function info() {
        return "{$this->group->group_id} {$this->period->period_id} {$this->subject->subject_name}";
    }

    public function generatePK() {
        $this->course_id = $this->group_id . $this->period_id . $this->subject_id;
        return $this->course_id;
    }

    public function scopeFromClinic($query, $clinic) {
        return $query->where('courses.clinic_id', $clinic->clinic_id);
    }

    public function have_teacher($user) {
        return \DB::table('course_teacher')
            ->where('course_id', $this->course_id)
            ->where('user_id', $user->user_id)
            ->count() > 0;
    }

    public function scopeWithData($query, $request) {
        return $query->where('subject_id', $request->subject_id)
                    ->where('group_id', $request->group_id)
                    ->where('period_id', $request->period_id);
    }
}
