<?php

namespace Tests\Unit;

use App\Chore\Infra\Memory\AttractionRepositoryMemory;
use App\Chore\UseCases\DTOs\AttractionResponse;
use App\Chore\UseCases\ListAttractions\ListAttractions;


class ListAttractionsTest extends UnitTestCase
{

    public function testMustBeReturnAListOfAttractions()
    {

        $dao = new AttractionRepositoryMemory();
        $listAttractions = new ListAttractions($dao);
        $output = $listAttractions->handle('Hillarius');
        $this->assertSame(2, count($output));
        $this->assertInstanceOf(AttractionResponse::class, $output[0]);
    }

}
