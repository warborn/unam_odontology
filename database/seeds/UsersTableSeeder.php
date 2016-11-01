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
        $clinic = App\Clinic::first();
        $super_user = App\Role::find('super user');
        $administrator = App\Role::find('administrator');
        $teacher = App\Role::find('teacher');
        $intern = App\Role::find('intern');
        $student = App\Role::find('student');
        $patient = App\Role::find('patient');
        factory(App\User::class, 14)->create()->each(function($user, $index) 
            use ($clinic, $super_user, $administrator, $teacher,
                 $intern, $student, $patient) {
            // Set user's personal information
        	$user->personal_information()->save(factory(App\PersonalInformation::class)->make());
            // Set clinic to user
            $clinic_role_user_id = $user->genClinicRoleUserPK($clinic, null);
            $user->clinics()->attach($clinic->clinic_id, 
                ['clinic_role_user_id' => $clinic_role_user_id]);
            
            if($index > 11) {
                // Set user's super user role
                $this->setRoleToUser($user, $clinic, $super_user);
            } else if($index > 9) {
                // Set user's administrator role
                $this->setRoleToUser($user, $clinic, $administrator);
            } else if($index > 7) {
                // Set user's teacher role
                $this->setRoleToUser($user, $clinic, $teacher);
                $user->teacher()->save(factory(App\Teacher::class)->make());
            } else if($index > 5) {
                // Set user's intern role
                $this->setRoleToUser($user, $clinic, $intern);
                $user->intern()->save(factory(App\Intern::class)->make());
            } else if($index > 3) {
                // Set user's student role
                $this->setRoleToUser($user, $clinic, $student);
                $user->student()->save(factory(App\Student::class)->make());
            } else if($index > 1) {
                // Set user's patient role
                $this->setRoleToUser($user, $clinic, $patient);
            }
        });
    }

    public function setRoleToUser($user, $clinic, $role) {
        $clinic_role_user_id = $user->genClinicRoleUserPK($clinic, $role);
        $user->roles()->attach($role->role_id, ['clinic_role_user_id' => $clinic_role_user_id, 'clinic_id' => $clinic->clinic_id]);
    }
}
