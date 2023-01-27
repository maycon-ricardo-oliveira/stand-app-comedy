<?php

namespace Database\Seeders;

use App\Models\Place;
use Illuminate\Database\Seeder;

class PlaceSeeder extends Seeder
{

    public function run()
    {
        foreach ($this->dataSet() as $item) {
            Place::create([
                "id" => $item['id'],
                "name" => $item['name'],
                "seats" => $item['seats'],
                "address" => $item['address'],
                "zipcode" => $item['zipcode'],
                "lat" => $item['lat'],
                "lng" => $item['lng'],
            ]);
        }
    }

    public function dataSet() {
        return [[
            "id" => '63d332d4be676',
            "name" => "Hillarius",
            "seats" => 200,
            "address" => "Av. Salim Farah Maluf, 1850 - Quarta Parada, SP",
            "zipcode" => "03157-200",
            "lat" => -23.546185,
            "lng" => -46.579876,
        ], [
            "id" => '63d332d4be678',
            "name" => "Espaço Cultural Urca",
            "seats" => 300,
            "address" => "Av. Salim Farah Maluf, 1850 - Quarta Parada, SP",
            "zipcode" => "03157-200",
            "lat" => -23.546185,
            "lng" => -46.579876,
        ]];
    }


}
