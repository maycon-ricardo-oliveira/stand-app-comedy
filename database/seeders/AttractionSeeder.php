<?php

namespace Database\Seeders;

use App\Models\Attraction;
use App\Models\Comedian;
use App\Models\Place;
use Illuminate\Database\Seeder;

class AttractionSeeder extends Seeder
{

    public function run()
    {

        foreach ($this->dataSet() as $item) {
            $comedian = Comedian::all();
            $place = Place::all();

            echo "Comedian id is: {$comedian[rand(0, count($comedian) -1)]->id}";
            echo "Place id is: {$place[rand(0, count($place) -1)]->id}";
            Attraction::create([
                'id' => $item['id'],
                'title' => $item['title'],
                'date' => $item['date'],
                'duration' => $item['duration'],
                'comedian_id' => $comedian[rand(0, count($comedian) -1)]->id,
                'place_id' => $place[rand(0, count($comedian) -1)]->id,
                'owner_id' => $item['owner_id']
            ]);
        }
    }

    public function dataSet() {
        return [[
            "id" => uniqid(),
            "title" => "Espalhando a Palavra",
            "date" => "2023-02-21 22:50:59",
            "duration" => '01:30',
            "owner_id" => '63d1c98e22ccb',
        ], [
            "id" => uniqid(),
            "title" => "O Problema é meu",
            "date" => "2023-02-21 22:50:59",
            "duration" => '01:30',
            "owner_id" => '63d1c98e22ccb',
        ]];
    }
}
