<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GroupsTableSeeder::class);
        $this->call(SubjectsTableSeeder::class);
        $this->call(PrivilegesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(FederalEntitiesTableSeeder::class);
        $this->call(ClinicsTableSeeder::class);
        $this->call(PeriodsTableSeeder::class);
        $this->call(DiseasesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CoursesSeeder::class);
        // $this->call(FormatsTableSeeder::class);
    }
}
