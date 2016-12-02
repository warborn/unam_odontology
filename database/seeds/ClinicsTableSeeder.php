<?php

use Illuminate\Database\Seeder;

class ClinicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// $records = 2;
    	// $addresses = App\Address::limit($records)->get();
     //    factory(App\Clinic::class, $records)->make()->each(function($clinic, $index) use ($addresses){
     //    	$clinic->address()->associate($addresses[$index]);
     //    	$clinic->save();
     //    });

        $address = App\Address::first();
        $clinic = factory(App\Clinic::class, 1)->make();
        $clinic->address()->associate($address);
        $clinic->save();
    }
}
