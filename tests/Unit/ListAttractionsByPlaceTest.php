<?php

namespace Tests\Unit;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Domain\Attraction;
use App\Chore\Infra\Memory\AttractionRepositoryMemory;
use App\Chore\UseCases\ListAttractionsByPlace\ListAttractionsByPlace;


class ListAttractionsByPlaceTest extends UnitTestCase
{

    public function testMustBeReturnAListOfAttractions()
    {
        $date = new DateTimeAdapter();
        $repo = new AttractionRepositoryMemory($date);
        $listAttractions = new ListAttractionsByPlace($repo);
        $output = $listAttractions->handle('Hillarius');
        $this->assertSame(2, count($output));
        $this->assertInstanceOf(Attraction::class, $output[0]);
    }

}
