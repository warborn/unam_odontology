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
       $course = App\Course::first();
       $intern = App\Intern::first();
       $clinic = App\Clinic::first();
       $address = App\Address::first();
       $medical_disease = App\Disease::where('type_of_disease', '=', 'general')->first();
       $dental_disease = App\Disease::where('type_of_disease', '=', 'odontologica')->first();
       factory(App\Format::class, 10)->make()->each(function($format) use ($course, $address, $student1, $intern, $clinic, $medical_disease, $dental_disease){
          $format->user_intern_id = $intern->user_id;
       		$format->clinic_id = $clinic->clinic_id;

       		// Setup patient's account
          // Create new user
          $user = App\User::create(['user_id' => uniqid('_PAS_'), 'password' => bcrypt('password')]);
          // Set user's personal information
          $personal_information = factory(App\PersonalInformation::class)->make();
          $personal_information->address()->associate($address);
          $user->personal_information()->save($personal_information);
          // Set account to user
          $account = new App\Account(['user_id' => $user->user_id, 'clinic_id' => $clinic->clinic_id]);
          $account->generatePK();
          $user->accounts()->save($account);

          // Create new patient
          $patient = factory(App\Patient::class)->make();
          $patient->federalEntity()->associate($address->federalEntity);
          $user->patient()->save($patient);

          // Associate patient with current format
          $format->patient()->associate($patient);

       		$format->general_disease = $medical_disease->disease_id;
       		$format->dental_disease = $dental_disease->disease_id;
          $format->save();
          $format->students()->attach($student1->user_id, ['course_id' => $course->course_id]);
       });

    }
}
