<?php

namespace Database\Seeders;


use App\Models\Comedian;
use Illuminate\Database\Seeder;

class ComedianSeeder extends Seeder
{

    public function run()
    {
        foreach ($this->dataSet() as $item) {
            Comedian::create([
                'id' => $item['id'],
                'name' => $item['name'],
                'mini_bio' => $item['miniBio'],
            ]);
        }
    }

    public function dataSet() {
        return [[
            "id" => '63d1c98de5cea',
            "name" => 'Afonso Padilha',
            "miniBio" => 'any_miniBio',
        ], [
            "id" => '63d1dc4d4b52d',
            "name" => 'Rodrigo Marques',
            "miniBio" => 'any_miniBio',
        ]];
    }
}
