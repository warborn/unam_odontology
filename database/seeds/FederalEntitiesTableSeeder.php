<?php

use Illuminate\Database\Seeder;

class FederalEntitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\FederalEntity::class, 3)->make()->each(function($entity) {
            $entity->generatePK();
            $entity->save();
        	$entity->addresses()->saveMany(factory(App\Address::class, 5)->make()->each(function($address) {
                $address->generatePK();
            }));
        });
    }
}
