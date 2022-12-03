<?php

use App\Chore\Domain\AttractionRepository;
use App\Chore\UseCases\ListAttractions;

class DaoStub implements AttractionRepository {


    public function getAttractionsInAPlace(string $place)
    {
        return [[
                'id' => '',
                'artist' => '',
                'place' => '',
                'date' => '',
                'title' => '',
            ], [
                'id' => '',
                'artist' => '',
                'place' => '',
                'date' => '',
                'title' => '',
            ],
        ];
    }
}

class ListAttractionsTest extends TestCase
{

    public function testMustBeReturnAListOfAttractions()
    {

        $dao = new DaoStub();
        $listAttractions = new ListAttractions($dao);
        $output = $listAttractions->handle('Hillarius');
        $this->assertSame(2, count($output));
    }

}