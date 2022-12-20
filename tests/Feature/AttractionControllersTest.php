<?php

namespace Tests\Feature;

use App\Http\Controllers\ListAttractionsByComedianController;
use App\Http\Controllers\ListAttractionsByLocationController;
use App\Http\Controllers\ListAttractionsController;
use Illuminate\Http\Request;

class AttractionControllersTest extends FeatureTestCase
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

    public function testMustBeReturn200OnListAttractionsByLocationController()
    {
        $request = new Request();
        $request->lat = '-23.546184';
        $request->lng = '-46.5798771';
        $request->distance = 100;
        $request->limit = 100;

        $controller = new ListAttractionsByLocationController();
        $response = $controller->handle($request);

        $this->assertSame(200, $response->getData()->status);
    }

}
