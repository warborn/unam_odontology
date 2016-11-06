<?php

use Illuminate\Database\Seeder;

class CoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courses = App\Course::all();
        $students = App\Student::all();
        $teachers = App\Teacher::all();
        $courses->each(function($course) use ($students, $teachers) {
        	$students->each(function($student) use ($course) {
        		$student->courses()->attach($course->course_id);
        	});

        	$teachers->each(function($teacher) use ($course) {
        		$teacher->courses()->attach($course->course_id);
        	});
        });
    }
}
