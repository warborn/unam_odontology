<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Role::class, 6)->create()->each(function($role) {
        	App\Privilege::all()->each(function($privilege) use ($role){
        		$role->privileges()->attach($privilege->privilege_id);
        	});
        });
    }
}
