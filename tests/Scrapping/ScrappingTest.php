<?php

namespace Tests\Scrapping;

use App\Chore\Modules\Pathfinder\Adapters\GuzzleHttpAdapter;
use App\Chore\Modules\Pathfinder\Entities\SampaIngressosGateway;
use App\Chore\Modules\Pathfinder\Entities\SymplaGateway;
use App\Chore\Modules\Pathfinder\UseCases\ImportAttractions;
use Tests\Unit\UnitTestCase;

class ScrappingTest extends UnitTestCase
{
    public function testScrapping()
    {

        $http = new GuzzleHttpAdapter();
        $finder = new SymplaGateway($http);

        $pathFinder = new ImportAttractions($finder);

        $response = $pathFinder->import();

        dd($response);

    }

}
