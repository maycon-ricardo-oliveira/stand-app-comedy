<?php

use App\Chore\Domain\AttractionRepository;
use App\Chore\UseCases\ListAttractions\AttractionResponse;
use App\Chore\UseCases\ListAttractions\ListAttractions;

class RepositoryStub implements AttractionRepository {


    public function getAttractionsInAPlace(string $place): array
    {
        return [[
                'id' => 'any_id',
                'artist' => 'any_artist',
                'place' => 'any_place',
                'date' => 'any_date',
                'title' => 'any_title',
            ], [
                'id' => 'any_id',
                'artist' => 'any_artist',
                'place' => 'any_place',
                'date' => 'any_date',
                'title' => 'any_title',
            ],
        ];
    }
}

class ListAttractionsTest extends TestCase
{

    public function testMustBeReturnAListOfAttractions()
    {

        $dao = new RepositoryStub();
        $listAttractions = new ListAttractions($dao);
        $output = $listAttractions->handle('Hillarius');
        $this->assertSame(2, count($output));
        $this->assertInstanceOf(AttractionResponse::class, $output[0]);
    }

}