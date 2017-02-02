<?php

use Illuminate\Database\Seeder;

class DiseasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\Disease::class, 10)->create();

        $keys = ['disease_id', 'disease_name', 'type_of_disease'];
        $results = getRowsFromCsv('diseases.csv', $keys);

        foreach ($results as $row) {
            $entity = App\Disease::create($row);
        }
    }
}
