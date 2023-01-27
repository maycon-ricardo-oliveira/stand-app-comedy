<?php

namespace App\Chore\Infra\Memory;


use App\Chore\Domain\Place;
use App\Chore\Domain\PlaceRepository;
use App\Chore\Infra\PlaceMapper;

class PlaceRepositoryMemory extends PlaceMapper implements PlaceRepository
{
    /**
     * @var Place[]
     */
    public array $places;

    /**
     * @param array $places
     * @throws \Exception
     */
    public function __construct(array $places = [])
    {
        parent::__construct();
        $this->generatePlaces($places);
    }
    /**
     * @param array $places
     * @return void
     * @throws \Exception
     */
    private function generatePlaces(array $places = []): void
    {
        if (empty($places)) $places = $this->dataSet();
        $this->places = $this->mapper($places);
    }

    public function dataSet() {
        return [[
            "id" => "any_id",
            "name" => "Espaço Cultural Urca",
            "seats" => 200,
            "address" => "Av. Salim Farah Maluf, 1850 - Quarta Parada, SP",
            "zipcode" => "03157-200",
            "lat" => -23.546185,
            "lng" => -46.579876,
            "distance" => 10,
        ], [
            "id" => "any_id",
            "name" => "Hillarius",
            "seats" => 200,
            "address" => "Av. Salim Farah Maluf, 1850 - Quarta Parada, SP",
            "zipcode" => "03157-200",
            "lat" => -23.546185,
            "lng" => -46.579876,
            "distance" => 20,
            ]
        ];
    }


    public function getPlaceById(string $id)
    {
        $response = array_values(array_filter($this->places, function ($place) use ($id) {
            return $place->id == $id;
        }));
        return count($response) == 0 ? null : $response[0];

    }
}
