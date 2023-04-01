<?php

namespace Tests\Unit;

use App\Chore\Modules\Comedians\Infra\Memory\ComedianRepositoryMemory;
use App\Chore\Modules\Comedians\UseCases\GetComedianDetailsById\GetComedianDetailsById;
use App\Chore\Modules\Places\Infra\Memory\PlaceRepositoryMemory;
use App\Chore\Modules\Places\UseCases\GetPlace\FindPlaceById;

class FindPlaceByIdTest extends UnitTestCase
{

    public function testFindPlaceById()
    {

        $repo = new PlaceRepositoryMemory();
        $anyId = 'any_id';

        $useCase = new FindPlaceById($repo);

        $response = $useCase->handle($anyId);
        $this->assertSame($anyId, $response->id);
    }

}
