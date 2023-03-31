<?php

namespace Tests\Unit;

use App\Chore\Modules\Adapters\DateTimeAdapter\DateTimeAdapter;
use App\Chore\Modules\Attractions\Infra\Memory\AttractionRepositoryMemory;
use App\Chore\Modules\Attractions\UseCases\ListAttractionsByComedianId\ListAttractionsByComedianId;
use App\Chore\Modules\Attractions\UseCases\ListAttractionsByComedianName\ListAttractionsByComedianName;

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

        $response = $useCase->handle('63d1c98de5cea');


        $this->assertSame('63a277fc7b250', $response[0]->id);
        $this->assertSame(1, count($response));
    }

}
