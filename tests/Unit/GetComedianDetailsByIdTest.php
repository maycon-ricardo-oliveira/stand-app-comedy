<?php

namespace Tests\Unit;

use App\Chore\Modules\Comedians\Infra\Memory\ComedianRepositoryMemory;
use App\Chore\Modules\Comedians\UseCases\GetComedianDetailsById\GetComedianDetailsById;

class GetComedianDetailsByIdTest extends UnitTestCase
{

    public function testGetComedianDetailsById()
    {

        $repo = new ComedianRepositoryMemory();
        $anyId = 'any_id_1';

        $useCase = new GetComedianDetailsById($repo);

        $response = $useCase->handle($anyId);
        $this->assertSame($anyId, $response->id);
    }

}
