<?php

namespace App\Chore\Infra\Memory;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Domain\Attraction;
use App\Chore\Domain\AttractionRepository;
use App\Chore\Domain\IDateTime;
use App\Chore\Domain\Place;

class AttractionRepositoryMemory implements AttractionRepository {


    /**
     * @var Attraction[]
     */
    private array $attractions;
    private IDateTime $time;

    /**
     * @param array $attractions
     * @throws \Exception
     */
    public function __construct(IDateTime $time, array $attractions = [])
    {
        $this->time = $time;
        $this->generateAttractions($attractions);
    }

    public function getAttractionsInAPlace(string $place): array
    {

        $response = array_filter($this->attractions, function ($attraction) use ($place) {
            return $attraction->place->name == $place;
        });
        return $response;
    }

    /**
     * @throws \Exception
     */
    public function getPlacesByLocation(string $lat, string $long, int $distance, int $limit = 20)
    {
        $places = array_filter($this->attractions, function ($attraction) use ($lat, $long, $distance, $limit) {
            return $attraction->place->distance <= $distance;
        });

        return $places;
    }


    /**
     * @param array $attractions
     * @return void
     * @throws \Exception
     */
    private function generateAttractions(array $attractions = []): void
    {
        if (empty($attractions)) {
            $attractions = $this->dataSet();
        }

        foreach ($attractions as $item) {
            $item = new Attraction(
                $item['id'],
                $item['title'],
                new DateTimeAdapter($item['date']),
                $this->time,
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
            $this->attractions[] = $item;
        }
    }

    public function dataSet() {
        return [[
            "id" => 6,
            "artist" => "Afonsoo repo",
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
            "artist" => "Rodrigo repo",
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

    public function getAttractionsByComedian(string $comedian)
    {
        $response = array_filter($this->attractions, function ($attraction) use ($comedian) {
            return str_contains($attraction->artist, $comedian);
        });
        return $response;
    }
}
