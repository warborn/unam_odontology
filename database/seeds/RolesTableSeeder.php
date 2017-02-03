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
        factory(App\Role::class, 5)->make()->each(function($role) {
            $role->generatePK();
            $role->save();
        });
    }
}
