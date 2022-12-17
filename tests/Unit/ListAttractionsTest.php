<?php

namespace Tests\Unit;

use App\Chore\Adapters\EloquentAdapter;
use App\Chore\Infra\Eloquent\AttractionRepositoryEloquent;
use App\Chore\Infra\Memory\AttractionRepositoryMemory;
use App\Chore\UseCases\ListAttractions\AttractionResponse;
use App\Chore\UseCases\ListAttractions\ListAttractions;
use App\Chore\UseCases\ListAttractionsByLocation\ListAttractionsByLocation;
use App\Models\Attraction;


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