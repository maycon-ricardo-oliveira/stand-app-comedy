<?php

namespace Database\Seeders;

 use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PlaceSeeder::class);
        $this->call(ComedianSeeder::class);
        $this->call(AttractionSeeder::class);

    }

}
