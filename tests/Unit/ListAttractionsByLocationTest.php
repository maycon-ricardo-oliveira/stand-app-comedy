<?php

namespace Tests\Unit;

use App\Chore\Adapters\MySqlAdapter;
use App\Chore\Infra\Memory\AttractionRepositoryMemory;
use App\Chore\Infra\MySql\AttractionDAODatabase;
use App\Chore\UseCases\ListAttractionsByLocation\ListAttractionsByLocation;


class ListAttractionsByLocationTest extends UnitTestCase
{
    public function testMustReturnAListOfAttractions()
    {

        $repo = new AttractionRepositoryMemory();
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

        $repo = new AttractionRepositoryMemory();
        $useCase = new ListAttractionsByLocation($repo);

        $lat = '-23.546184';
        $lng = '-46.5798771';
        $distanceInKM = 10;
        $limit = 100;

        $response = $useCase->handle($lat, $lng, $distanceInKM, $limit);

        $this->assertSame("Afonso Padilha", $response[0]->artist);

    }

}