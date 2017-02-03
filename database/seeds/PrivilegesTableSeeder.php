<?php

use Illuminate\Database\Seeder;

class PrivilegesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\Privilege::class, 8)->make()->each(function($privilege) {
        // 	$privilege->generatePK();
        // 	$privilege->save();
        // });

        $keys = ['privilege_name'];
        $results = getRowsFromCsv('privileges.csv', $keys);

        foreach ($results as $row) {
            $entity = new App\Privilege($row);
            $entity->generatePK();
            $entity->save();
        }
    }
}
