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
        $repo = new AttractionRepositoryMemory($date, $this->dataSet());
        $useCase = new ListAttractionsByComedian($repo);

        $response = $useCase->handle('Afonso');

        $this->assertSame($this->dataSet()[0]['id'], $response[0]->id);
        $this->assertSame(1, count($response));
    }

    /**
     * @throws \Exception
     */
    public function testMustReturnNullWhenNotKnowNameIsPassed()
    {

        $date = new DateTimeAdapter();
        $repo = new AttractionRepositoryMemory($date, $this->dataSet());
        $useCase = new ListAttractionsByComedian($repo);

        $response = $useCase->handle('any_name');

        $this->assertCount(0, $response);
    }

    public function dataSet() {
        return [[
            "id" => '6',
            "artist" => "Afonso Padilha" ,
            "date" => "2023-01-10 00:00:00",
            "title" => "Espalhando a Palavra",
            "place_id" => 6,
            "name" => "Hillarius",
            "address" => "Av. Salim Farah Maluf, 1850 - Quarta Parada, SP",
            "zipcode" => "03157-200",
            "lat" => -23.546185,
            "lng" => -46.579876,
            "distance" => 10
        ], [
            "id" => '6',
            "artist" => "Rodrigo Marques",
            "place" => "Espaço Cultural Urca",
            "date" => "2023-01-09 00:00:00",
            "title" => "O Problema é meu",
            "place_id" => 6,
            "name" => "Hillarius",
            "address" => "Av. Salim Farah Maluf, 1850 - Quarta Parada, SP",
            "zipcode" => "03157-200",
            "lat" => -23.546185,
            "lng" => -46.579876,
            "distance" => 12
        ]];
    }

}
