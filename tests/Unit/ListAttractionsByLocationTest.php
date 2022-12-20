<?php

namespace Tests\Unit;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Adapters\MySqlAdapter;
use App\Chore\Infra\Memory\AttractionRepositoryMemory;
use App\Chore\Infra\MySql\AttractionDAODatabase;
use App\Chore\UseCases\ListAttractionsByLocation\ListAttractionsByLocation;


class ListAttractionsByLocationTest extends UnitTestCase
{
    public function testMustReturnAListOfAttractions()
    {
        $date = new DateTimeAdapter();
        $repo = new AttractionRepositoryMemory($date);
        $useCase = new ListAttractionsByLocation($repo);

        $lat = '-23.546184';
        $lng = '-46.5798771';
        $distanceInKM = 10;
        $limit = 100;

        $response = $useCase->handle($lat, $lng, $distanceInKM, $limit);

        $this->assertSame(2, count($response));
    }

    public function testMusEnsureOnlyAttractionsAreLowerDistanceThenDistancePassed()
    {
        $date = new DateTimeAdapter();
        $repo = new AttractionRepositoryMemory($date, $this->dataSet());
        $useCase = new ListAttractionsByLocation($repo);

        $lat = '-23.546184';
        $lng = '-46.5798771';
        $distanceInKM = 10;
        $limit = 100;

        $response = $useCase->handle($lat, $lng, $distanceInKM, $limit);

        $this->assertSame($this->dataSet()[0]['id'], $response[0]->id);
        $this->assertSame(1, count($response));
    }

    /**
     * @throws \Exception
     */
    public function testMustReturnAttractionsWithSpecificDaysDate()
    {

        $date = new DateTimeAdapter('2023-01-08 00:00:00');
        $repo = new AttractionRepositoryMemory($date, $this->dataSet());
        $useCase = new ListAttractionsByLocation($repo);

        $lat = '-23.546184';
        $lng = '-46.5798771';
        $distanceInKM = 10;
        $limit = 100;

        $response = $useCase->handle($lat, $lng, $distanceInKM, $limit);

        $this->assertSame("2 days and 0:0 hours", $response[0]->timeToEvent);
    }

    /**
     * @throws \Exception
     */
    public function testMustReturnFalseWhenEventIsPassed()
    {

        $date = new DateTimeAdapter('2023-01-11 00:00:01');
        $repo = new AttractionRepositoryMemory($date, $this->dataSet());
        $useCase = new ListAttractionsByLocation($repo);

        $lat = '-23.546184';
        $lng = '-46.5798771';
        $distanceInKM = 12;
        $limit = 100;

        $response = $useCase->handle($lat, $lng, $distanceInKM, $limit);

        $this->assertFalse($response[0]->timeToEvent);
    }

    public function dataSet() {
        return [[
            "id" => '6',
            "artist" => "Afonso ",
            "date" => "2023-01-10 00:00:00",
            "title" => "Espalhando a Palavra",
            "place_id" => 6,
            "name" => "Hillarius",
            "address" => "Av. Salim Farah Maluf, 1850 - Quarta Parada, SP",
            "zipcode" => "03157-200",
            "lat" => -23.546185,
            "lng" => -46.579876,
            "distance" => 10
        ], [
            "id" => '7',
            "artist" => "Rodrigo ",
            "place" => "Espaço Cultural Urca",
            "date" => "2023-01-09 00:00:00",
            "title" => "O Problema é meu",
            "place_id" => 6,
            "name" => "Hillarius",
            "address" => "Av. Salim Farah Maluf, 1850 - Quarta Parada, SP",
            "zipcode" => "03157-200",
            "lat" => -23.546185,
            "lng" => -46.579876,
            "distance" => 12
        ]];
    }
}
