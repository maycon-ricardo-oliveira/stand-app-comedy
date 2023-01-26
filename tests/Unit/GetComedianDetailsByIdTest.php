<?php

namespace Tests\Unit;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Infra\Memory\AttractionRepositoryMemory;
use App\Chore\Infra\Memory\ComedianRepositoryMemory;
use App\Chore\UseCases\GetComedianDetailsById\GetComedianDetailsById;
use App\Chore\UseCases\ListAttractionsByLocation\ListAttractionsByLocation;

class GetComedianDetailsByIdTest extends UnitTestCase
{

    public function testGetComedianDetailsById()
    {

        $date = new DateTimeAdapter();
        $repo = new ComedianRepositoryMemory($date);
        $anyId = 'any_id_1';

        $useCase = new GetComedianDetailsById($repo);

        $response = $useCase->handle($anyId);
        $this->assertSame($anyId, $response->id);
    }

}
