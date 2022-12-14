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
            "id" => uniqid(),
            "name" => 'Afonso Padilha',
            "miniBio" => 'any_miniBio',
        ], [
            "id" => uniqid(),
            "name" => 'Rodrigo Marques',
            "miniBio" => 'any_miniBio',
        ]];
    }
}
