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
        // factory(App\Role::class, 5)->make()->each(function($role) {
        //     $role->generatePK();
        //     $role->save();
        // });

        $keys = ['role_name', 'role_description'];
        $results = getRowsFromCsv('roles.csv', $keys, "|");
        foreach ($results as $row) {
            $entity = new App\Role($row);
            $entity->generatePK();
            $entity->save();
        }

        $keys = ['role_id', 'privilege_id'];
        $results = getRowsFromCsv('privilege_role.csv', $keys, "|");

        foreach ($results as $row) {
            DB::table('privilege_role')->insert($row);
        }
    }
}
