<?php

namespace Tests\Feature;

use App\Http\Controllers\ListAttractionsByComedianController;
use App\Http\Controllers\ListAttractionsController;
use Illuminate\Http\Request;

class ListAttractionsByPlaceControllerTest extends FeatureTestCase
{

    public function testMustBeReturn200OnListAttractionsController()
    {

        $request = new Request();
        $request->place = 'Hillarius';

        $controller = new ListAttractionsController();
        $response = $controller->handle($request);

        $this->assertSame(200, $response->getData()->status);

    }
    public function testMustBeReturn200OnListAttractionsByComedianController()
    {

        $request = new Request();
        $request->comedian = 'Afonso';

        $controller = new ListAttractionsByComedianController();

        $response = $controller->handle($request);

        $this->assertSame(200, $response->getData()->status);

    }

}
