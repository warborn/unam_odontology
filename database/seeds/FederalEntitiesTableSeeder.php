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

        // $keys = ['federal_entity_name'];
        // $results = getRowsFromCsv('federal_entities.csv', $keys);

        // foreach ($results as $row) {
        //     $entity = new App\FederalEntity($row);
        //     $entity->generatePK();
        //     $entity->save();
        // }

        // $keys = ['postal_code', 'settlement', 'municipality'];
        // $results = getRowsFromCsv('addresses_mexico.csv', $keys, "|");

        // foreach ($results as $row) {
        //     // $values = ['postpal_code' => $row['postal_code'], 'settlement' => $row['settlement']];
        //     $entity = App\Address::firstOrNew($row);
        //     $entity->generatePK();
        //     $entity->federal_entity_id = 'ETDDMX';
        //     $entity->save();
        // }

        // $results = getRowsFromCsv('addresses_df.csv', $keys, "|");

        // foreach ($results as $row) {
        //     $entity = App\Address::firstOrNew($row);
        //     $entity->generatePK();
        //     $entity->federal_entity_id = 'DTFE';
        //     $entity->save();
        // }

    }
}
