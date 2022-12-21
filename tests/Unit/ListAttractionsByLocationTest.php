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

        $this->assertSame(1, count($response));
    }

    public function testMustEnsureOnlyAttractionsAreLowerDistanceThenDistancePassed()
    {
        $date = new DateTimeAdapter();
        $repo = new AttractionRepositoryMemory($date);
        $useCase = new ListAttractionsByLocation($repo);

        $lat = '-23.546184';
        $lng = '-46.5798771';
        $distanceInKM = 10;
        $limit = 100;

        $response = $useCase->handle($lat, $lng, $distanceInKM, $limit);

        $this->assertSame('63a277fc7b250', $response[0]->id);
        $this->assertSame(1, count($response));
    }

    /**
     * @throws \Exception
     */
    public function testMustReturnAttractionsWithSpecificDaysDate()
    {

        $date = new DateTimeAdapter('2023-01-08 00:00:00');
        $repo = new AttractionRepositoryMemory($date);
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
        $repo = new AttractionRepositoryMemory($date);
        $useCase = new ListAttractionsByLocation($repo);

        $lat = '-23.546184';
        $lng = '-46.5798771';
        $distanceInKM = 12;
        $limit = 100;

        $response = $useCase->handle($lat, $lng, $distanceInKM, $limit);

        $this->assertFalse($response[0]->timeToEvent);
    }

}
