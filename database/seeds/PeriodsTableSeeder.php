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
        $clinic = App\Clinic::first();
        factory(App\Period::class, 2)->create()->each(function($period) use ($clinic, $group, $subjects){
        	$subjects->each(function($subject) use ($clinic, $group, $period) {
        		$course_id = $group->group_id . $period->period_id . $subject->subject_id;
        		$period->subjects()->attach($subject->subject_id, ['course_id' => $course_id, 'group_id' => $group->group_id, 'clinic_id' => $clinic->clinic_id]);
        	});
        });
    }
}