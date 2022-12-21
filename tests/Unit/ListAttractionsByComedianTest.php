<?php

namespace Tests\Unit;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Infra\Memory\AttractionRepositoryMemory;
use App\Chore\UseCases\ListAttractionsByComedian\ListAttractionsByComedian;

class ListAttractionsByComedianTest extends UnitTestCase
{

    /**
     * @throws \Exception
     */
    public function testMustReturnAttractionsOfAnArtistNameIsPassed()
    {

        $date = new DateTimeAdapter();
        $repo = new AttractionRepositoryMemory($date);
        $useCase = new ListAttractionsByComedian($repo);

        $response = $useCase->handle('Afonso');

        $this->assertSame('63a277fc7b250', $response[0]->id);
        $this->assertSame(1, count($response));
    }

    /**
     * @throws \Exception
     */
    public function testMustReturnNullWhenNotKnowNameIsPassed()
    {

        $date = new DateTimeAdapter();
        $repo = new AttractionRepositoryMemory($date);
        $useCase = new ListAttractionsByComedian($repo);

        $response = $useCase->handle('any_name');

        $this->assertCount(0, $response);
    }

}
