<?php

namespace App\Chore\Infra\Memory;

use App\Chore\Domain\Attraction;
use App\Chore\Domain\AttractionRepository;
use App\Chore\Domain\IDateTime;
use App\Chore\Infra\AttractionMapper;

class AttractionRepositoryMemory extends AttractionMapper implements AttractionRepository {


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
        parent::__construct();
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
        if (empty($attractions)) $attractions = $this->dataSet();
        $this->attractions = $this->mapper($this->time, $attractions);
    }

    public function dataSet() {
        return [[
            "id" => '63a277fc7b250',
            "comedianName" => "Afonso",
            "date" => "2023-01-10 00:00:00",
            "seats" => 200,
            "title" => "Espalhando a Palavra",
            "miniBio" => "Mini bio do Afonso",
            "place_id" => '63a277fc7358b',
            "placeName" => "Hillarius",
            "address" => "Av. Salim Farah Maluf, 1850 - Quarta Parada, SP",
            "zipcode" => "03157-200",
            "lat" => -23.546185,
            "lng" => -46.579876,
            "distance" => 10,
            "status" => 'draft',
            "owner" => '63d1c98e22ccb'
        ], [
            "id" => '63a277fc7b251',
            "comedianName" => "Rodrigo Marques",
            "place" => "Espaço Cultural Urca",
            "date" => "2023-01-09 00:00:00",
            "title" => "O Problema é meu",
            "miniBio" => "Mini bio do Rodrigo",
            "seats" => 200,
            "place_id" => '63a277fc7358e',
            "placeName" => "Hillarius",
            "address" => "Av. Salim Farah Maluf, 1850 - Quarta Parada, SP",
            "zipcode" => "03157-200",
            "lat" => -23.546185,
            "lng" => -46.579876,
            "distance" => 20,
            "status" => 'draft',
            "owner" => '63d1c98e22ccb'
        ]];
    }

    public function getAttractionsByComedianName(string $comedianName)
    {
        $response = array_filter($this->attractions, function ($attraction) use ($comedianName) {
            return str_contains($attraction->comedian->name, $comedianName);
        });
        return $response;
    }

    public function getAttractionsByComedianId(string $comedianId)
    {
        $response = array_filter($this->attractions, function ($attraction) use ($comedianId) {
            return str_contains($attraction->comedian->id, $comedianId);
        });
        return $response;
    }

}
