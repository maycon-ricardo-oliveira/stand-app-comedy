<?php

namespace Tests\Unit;

use App\Chore\Adapters\EloquentAdapter;
use App\Chore\Adapters\MySqlAdapter;
use App\Chore\Infra\Eloquent\AttractionRepositoryDatabase;
use App\Chore\UseCases\ListAttractionsByLocation\ListAttractionsByLocation;
use App\Models\Attraction;
use App\Models\Place;

class ListAttractionsByLocationTest extends UnitTestCase
{
    public function testMustReturnAListOfAttractions()
    {

        $adapter = new MySqlAdapter();
        $repo = new AttractionRepositoryDatabase($adapter);
        $useCase = new ListAttractionsByLocation($repo);

        $lat = '-23.546184';
        $lng = '-46.5798771';
        $response = $useCase->handle($lat, $lng);

        var_dump($response);

        $this->assertTrue(true);
    }

}
