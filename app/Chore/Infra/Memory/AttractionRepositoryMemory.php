<?php

namespace App\Chore\Infra\Memory;

use App\Chore\Domain\Attraction;
use App\Chore\Domain\AttractionRepository;
use App\Chore\Domain\Place;

class AttractionRepositoryMemory implements AttractionRepository {


    /**
     * @var Attraction[]
     */
    private array $attractions;

    /**
     * @param array $attractions
     */
    public function __construct(array $attractions = [])
    {

        if (empty($audiobooks)) {
            $this->attractions = $this->dataSet();
            return;
        }
        $this->attractions = $attractions;
    }
    public function getAttractionsInAPlace(string $place): array
    {
        $response = array_filter($this->attractions, function ($attraction) use ($place) {
            return $attraction['name'] == $place;
        });
        return $response;
    }

    public function getPlacesByLocation(string $lat, string $long, int $distance, int $limit = 20)
    {
        $response = array_filter($this->attractions, function ($attraction) use ($lat, $long, $distance, $limit) {
            return $attraction['distance'] <= $distance;
        });
        return $response;
    }

    private function generateAttractions()
    {
        $attractions = [];
        $dataset = $this->dataSet();
        foreach ($dataset as $key => $item) {
            $item = new Attraction(
                $key,
                $item['title'],
                $item['date'],
                $item['artist'],
                new Place(
                    $item["place_id"],
                    $item["name"],
                    $item["address"],
                    $item["zipcode"],
                    $item["lat"],
                    $item["lng"],
                    $item["distance"]
                ),
            );
            $attractions[] = $item;
        }

        return $attractions;
    }

    public function dataSet() {
        return [[
            "id" => 6,
            "artist" => "Afonso Padilha",
            "date" => "2023-02-21 16:14:08",
            "title" => "Espalhando a Palavra",
            "place_id" => 6,
            "name" => "Hillarius",
            "address" => "Av. Salim Farah Maluf, 1850 - Quarta Parada, SP",
            "zipcode" => "03157-200",
            "lat" => -23.546185,
            "lng" => -46.579876,
            "distance" => 0.0001320590301398874
        ], [
            "id" => 6,
            "artist" => "Rodrigo Marques",
            "place" => "Espaço Cultural Urca",
            "date" => "2023-02-21 22:50:59",
            "title" => "O Problema é meu",
            "place_id" => 6,
            "name" => "Hillarius",
            "address" => "Av. Salim Farah Maluf, 1850 - Quarta Parada, SP",
            "zipcode" => "03157-200",
            "lat" => -23.546185,
            "lng" => -46.579876,
            "distance" => 0.0001320590301398874
        ]];
    }
}
