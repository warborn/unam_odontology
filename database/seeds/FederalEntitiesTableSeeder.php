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
        factory(App\FederalEntity::class, 3)->create()->each(function($entity) {
        	$entity->addresses()->saveMany(factory(App\Address::class, 5)->make());
        });
    }
}
