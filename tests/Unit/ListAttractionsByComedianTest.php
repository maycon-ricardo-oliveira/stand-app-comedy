<?php

namespace Tests\Unit;

use App\Chore\Infra\Memory\AttractionRepositoryMemory;
use App\Chore\UseCases\ListAttractionsByComedian\ListAttractionsByComedian;

class ListAttractionsByComedianTest extends UnitTestCase
{

    public function testMusEnsureOnlyAttractionsAreLowerDistanceThenDistancePassed()
    {

        $repo = new AttractionRepositoryMemory($this->dataSet());
        $useCase = new ListAttractionsByComedian($repo);

        $response = $useCase->handle('Afonso');

        $this->assertSame($this->dataSet()[0]['id'], $response[0]->id);
        $this->assertSame(1, count($response));
    }

    public function dataSet() {
        return [[
            "id" => '6',
            "artist" => "Afonso Padilha",
            "date" => "2023-02-21 16:14:08",
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
            "date" => "2023-02-21 22:50:59",
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
