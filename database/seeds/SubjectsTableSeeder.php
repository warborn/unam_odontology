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
        factory(App\Subject::class, 9)->make()->each(function($subject) {
        	$subject->generatePK();
        	$subject->save();
        });
    }
}
