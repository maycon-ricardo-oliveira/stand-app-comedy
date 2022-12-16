<?php

namespace Tests\Unit;

use App\Chore\Domain\AttractionRepository;
use App\Chore\UseCases\ListAttractions\AttractionResponse;
use App\Chore\UseCases\ListAttractions\ListAttractions;
use Tests\Mocks\AttractionRepositoryMemory;


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
