<?php

use Illuminate\Database\Seeder;

class FormatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $student1 = App\Student::first();
       $student2 = App\Student::skip(1)->first();
       $course = App\Course::first();
       $intern = App\Intern::first();
       $clinic = App\Clinic::first();
       $patient = App\Patient::first();
       $medical_disease = App\Disease::where('type_of_disease', '=', 'medical')->first();
       $dental_disease = App\Disease::where('type_of_disease', '=', 'dental')->first();
       factory(App\Format::class, 10)->make()->each(function($format) use ($course, $student1, $student2, $intern, $clinic, $patient, $medical_disease, $dental_disease){
          $format->user_intern_id = $intern->user_id;
       		$format->clinic_id = $clinic->clinic_id;
       		$format->user_patient_id = $patient->user_id;
       		$format->general_disease = $medical_disease->disease_id;
       		$format->dental_disease = $dental_disease->disease_id;
          $format->save();
          $format->students()->attach($student1->user_id, ['course_id' => $course->course_id]);
          $format->students()->attach($student2->user_id, ['course_id' => $course->course_id]);
       });

    }
}
