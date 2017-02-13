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
        $federal_entity = App\FederalEntity::find('CIDMXI');
        $address = $federal_entity->addresses()->first();
        $clinic = App\Clinic::first();
        factory(App\User::class, 5)->create()->each(function($user) 
            use ($clinic, $federal_entity, $address) {
            // Set user's personal information
            $personal_information = factory(App\PersonalInformation::class)->make();
            $personal_information->address()->associate($address);
        	$user->personal_information()->save($personal_information);
            // Set account to user
            $account = new App\Account(['user_id' => $user->user_id, 'clinic_id' => $clinic->clinic_id]);
            $account->generatePK();
            $user->accounts()->save($account);

            $role = App\Role::where('role_name', '=', $user->user_id)->first();
            if($role) {
                $this->setRoleToAccount($account, $role);
                $account->assign_profile($role);
            }
        });
    }

    public function setRoleToAccount($account, $role) {
        $account->roles()->attach($role->role_id);
    }
}
