<?php

namespace Tests\Unit;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Domain\Attraction;
use App\Chore\Infra\Memory\AttractionRepositoryMemory;
use App\Chore\UseCases\DTOs\AttractionResponse;
use App\Chore\UseCases\ListAttractions\ListAttractions;


class ListAttractionsTest extends UnitTestCase
{

    public function testMustBeReturnAListOfAttractions()
    {
        $date = new DateTimeAdapter();
        $repo = new AttractionRepositoryMemory($date);
        $listAttractions = new ListAttractions($repo);
        $output = $listAttractions->handle('Hillarius');
        $this->assertSame(2, count($output));
        $this->assertInstanceOf(Attraction::class, $output[0]);
    }

}
