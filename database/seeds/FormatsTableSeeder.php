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
       $student0 = App\Student::all()[0];
       $student1 = App\Student::all()[1];
       $course= App\Course::first();
       $intern = App\Intern::first();
       $clinic = App\Clinic::first();
       $patient = App\Patient::first();
       $medical_disease = App\Disease::where('type_of_disease', '=', 'medical')->get()[0];
       $dental_disease = App\Disease::where('type_of_disease', '=', 'dental')->get()[0];
       factory(App\Format::class, 10)->make()->each(function($format) use ($student0, $student1, $intern, $clinic, $patient, $medical_disease, $dental_disease){
          $format->user_intern_id = $intern->user_id;
       		$format->clinic_id = $clinic->clinic_id;
       		$format->user_patient_id = $patient->user_id;
       		$format->general_disease = $medical_disease->disease_id;
       		$format->dental_disease = $dental_disease->disease_id;
          $format->save();
          $format->students()->attach($student0->user_id, ['group_period_subject_id'=>$course->group_period_subject_id]);
          $format->students()->attach($student1->user_id, ['group_period_subject_id'=>$course->group_period_subject_id]);
       });

    }
}
