<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $federal_entity = App\FederalEntity::first();
        $clinic = App\Clinic::first();
        $super_user = App\Role::find('super user');
        $administrator = App\Role::find('administrator');
        $teacher = App\Role::find('teacher');
        $intern = App\Role::find('intern');
        $student = App\Role::find('student');
        $patient = App\Role::find('patient');
        factory(App\User::class, 14)->create()->each(function($user, $index) 
            use ($clinic, $super_user, $administrator, $teacher,
                 $intern, $student, $patient, $federal_entity) {
            // Set user's personal information
        	$user->personal_information()->save(factory(App\PersonalInformation::class)->make());
            // Set account to user
            $account = new App\Account(['account_id' => $user->genAccountPK($clinic),
                'user_id' => $user->user_id, 'clinic_id' => $clinic->clinic_id]);
            $user->accounts()->save($account);
            
            if($index > 11) {
                // Set user's super user role
                $this->setRoleToAccount($account, $super_user);
            } else if($index > 9) {
                // Set user's administrator role
                $this->setRoleToAccount($account, $administrator);
            } else if($index > 7) {
                // Set user's teacher role
                $this->setRoleToAccount($account, $teacher);
                $user->teacher()->save(factory(App\Teacher::class)->make());
            } else if($index > 5) {
                // Set user's intern role
                $this->setRoleToAccount($account, $intern);
                $user->intern()->save(factory(App\Intern::class)->make());
            } else if($index > 3) {
                // Set user's student role
                $this->setRoleToAccount($account, $student);
                $user->student()->save(factory(App\Student::class)->make());
            } else if($index > 1) {
                // Set user's patient role
                $this->setRoleToAccount($account, $patient);
                $patient = factory(App\Patient::class)->make();
                $patient->federal_entity_id = $federal_entity->federal_entity_id;
                $user->patient()->save($patient);
            }
        });
    }

    public function setRoleToAccount($account, $role) {
        $account->roles()->attach($role->role_id);
    }
}
