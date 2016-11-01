<?php

use Illuminate\Database\Seeder;

class PeriodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    		$group = App\Group::first();
    		$subjects = App\Subject::all();
        factory(App\Period::class, 2)->create()->each(function($period) use ($group, $subjects){
        	$subjects->each(function($subject) use ($group, $period) {
        		$group_period_subject_id = $group->group_id . $period->period_id . $subject->subject_id;
        		$period->subjects()->attach($subject->subject_id, ['group_period_subject_id' => $group_period_subject_id, 'group_id' => $group->group_id]);
        	});
        });
    }
}