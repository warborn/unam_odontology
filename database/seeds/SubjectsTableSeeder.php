<?php

use Illuminate\Database\Seeder;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\Subject::class, 9)->make()->each(function($subject) {
        // 	$subject->generatePK();
        // 	$subject->save();
        // });

        $keys = ['subject_id', 'subject_name', 'semester'];
        $results = getRowsFromCsv('subjects.csv', $keys, "|");
        foreach ($results as $row) {
            $entity = new App\Subject($row);
            $entity->subject_name = strtoupper($entity->subject_name);
            $entity->save();
        }
    }
}
