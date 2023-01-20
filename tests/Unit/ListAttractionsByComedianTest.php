<?php

namespace Tests\Unit;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Infra\Memory\AttractionRepositoryMemory;
use App\Chore\UseCases\ListAttractionsByComedianId\ListAttractionsByComedianId;
use App\Chore\UseCases\ListAttractionsByComedianName\ListAttractionsByComedianName;

class ListAttractionsByComedianTest extends UnitTestCase
{

    /**
     * @throws \Exception
     */
    public function testMustReturnAttractionsOfAnArtistNameIsPassed()
    {

        $date = new DateTimeAdapter();
        $repo = new AttractionRepositoryMemory($date);
        $useCase = new ListAttractionsByComedianName($repo);

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
        $useCase = new ListAttractionsByComedianName($repo);

        $response = $useCase->handle('any_name');

        $this->assertCount(0, $response);
    }

    /**
     * @throws \Exception
     */
    public function testMustReturnAttractionsOfAnArtistIdIsPassed()
    {

        $date = new DateTimeAdapter();
        $repo = new AttractionRepositoryMemory($date);
        $useCase = new ListAttractionsByComedianId($repo);

        $response = $useCase->handle('63a277fc7b250');

        $this->assertSame('63a277fc7b250', $response[0]->id);
        $this->assertSame(1, count($response));
    }

}
