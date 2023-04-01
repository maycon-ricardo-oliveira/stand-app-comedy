<?php

namespace App\Chore\Modules\Attractions\Infra\Memory;

use App\Chore\Modules\Adapters\DateTimeAdapter\IDateTime;
use App\Chore\Modules\Attractions\Entities\Attraction;
use App\Chore\Modules\Attractions\Entities\AttractionRepository;
use App\Chore\Modules\Attractions\Infra\AttractionMapper;

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
            "attractionId" => '63a277fc7b250',
            "comedianName" => "Afonso",
            "comedianId" => "63d1c98de5cea",
            "placeId" => "63d332d4be676",
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
            "status" => 'published',
            "image" => 'https://image.com/image.jpg',
            "duration" => '180',
            "owner" => '63d1c98e22ccb'
        ], [
            "attractionId" => '63a277fc7b251',
            "comedianId" => '63d1dc4d4b52d',
            "comedianName" => "Rodrigo Marques",
            "place" => "Espaço Cultural Urca",
            "date" => "2023-01-09 00:00:00",
            "title" => "O Problema é meu",
            "miniBio" => "Mini bio do Rodrigo",
            "duration" => '180',
            "seats" => 200,
            "place_id" => '63a277fc7358e',
            "placeName" => "Hillarius",
            "placeId" => "63d332d4be676",
            "address" => "Av. Salim Farah Maluf, 1850 - Quarta Parada, SP",
            "zipcode" => "03157-200",
            "image" => 'https://image.com/image.jpg',
            "lat" => -23.546185,
            "lng" => -46.579876,
            "distance" => 20,
            "status" => 'published',
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

    public function registerAttraction(Attraction $attractionData, IDateTime $date): bool
    {
        $this->attractions[] = $attractionData;
        return true;
    }

    public function findAttractionById(string $attractionId): ?Attraction
    {
        $response = array_values(array_filter($this->attractions, function ($attraction) use ($attractionId) {
            return $attraction->id == $attractionId;
        }));
        return count($response) == 0 ? null : $response[0];
    }

    public function updateAttraction(Attraction $attractionData): bool
    {
        foreach ($this->attractions as $attraction) {
            if ($attraction->id == $attractionData->id) {
                $attraction->status = $attractionData->status;
                return true;
            }

        }

        return false;
    }
}
