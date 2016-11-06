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
        $super_user = App\Role::where('role_name', '=', 'super user')->first();
        $administrator = App\Role::where('role_name', '=', 'administrator')->first();
        $teacher = App\Role::where('role_name', '=', 'teacher')->first();
        $intern = App\Role::where('role_name', '=', 'intern')->first();
        $student = App\Role::where('role_name', '=', 'student')->first();
        $patient = App\Role::where('role_name', '=', 'patient')->first();
        $add_user_privilege = App\Privilege::where('privilege_name', '=', 'add new user')->first();
        $add_role_privilege = App\Privilege::where('privilege_name', '=', 'add role to user')->first();
        factory(App\User::class, 14)->create()->each(function($user, $index) 
            use ($clinic, $super_user, $administrator, $teacher,
                 $intern, $student, $patient, $federal_entity, 
                 $add_user_privilege, $add_role_privilege) {
            // Set user's personal information
        	$user->personal_information()->save(factory(App\PersonalInformation::class)->make());
            // Set account to user
            $account = new App\Account(['account_id' => $user->genAccountPK($clinic),
                'user_id' => $user->user_id, 'clinic_id' => $clinic->clinic_id]);
            $user->accounts()->save($account);
            // Add user creation movement
            factory(App\Movement::class)->make()
                    ->buildByAccounts($account, $account, $add_user_privilege)
                    ->save();
            
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

            if($index > 1) {
                // Add role to account movement
                factory(App\Movement::class)->make()
                    ->buildByAccounts($account, $account, $add_role_privilege)
                    ->save();
            }
        });
    }

    public function setRoleToAccount($account, $role) {
        $account->roles()->attach($role->role_id);
    }
}
