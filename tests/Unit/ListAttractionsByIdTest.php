<?php

namespace Tests\Unit;

use App\Chore\Modules\Adapters\DateTimeAdapter\DateTimeAdapter;
use App\Chore\Modules\Attractions\Entities\Attraction;
use App\Chore\Modules\Attractions\Infra\Memory\AttractionRepositoryMemory;
use App\Chore\Modules\Attractions\UseCases\GetAttractionById\GetAttractionById;
use App\Chore\Modules\Attractions\UseCases\ListAttractionsByPlace\ListAttractionsByPlace;


class ListAttractionsByIdTest extends UnitTestCase
{

    public function testMustBeReturnAttraction()
    {
        $attractionId = '63a277fc7b251';
        $date = new DateTimeAdapter();
        $repo = new AttractionRepositoryMemory($date);
        $listAttractions = new GetAttractionById($repo);
        $output = $listAttractions->handle($attractionId);
        $this->assertInstanceOf(Attraction::class, $output);
        $this->assertSame($output->id, $attractionId);
    }

    public function testMustBeReturnExceptionUsingAInvalidId()
    {

        $attractionId = 'invalid';
        $date = new DateTimeAdapter();
        $repo = new AttractionRepositoryMemory($date);
        $listAttractions = new GetAttractionById($repo);

        $this->expectExceptionMessage('Attraction not found');

        $listAttractions->handle($attractionId);
    }

}
