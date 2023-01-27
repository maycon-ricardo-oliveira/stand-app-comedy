<?php

namespace Tests\Feature;

use App\Http\Controllers\ListAttractionsByComedianController;
use App\Http\Controllers\ListAttractionsByComedianNameController;
use App\Http\Controllers\ListAttractionsByLocationController;
use App\Http\Controllers\ListAttractionsByPlaceController;
use Illuminate\Http\Request;

class AttractionControllersTest extends FeatureTestCase
{

    public function testMustBeReturn200OnListAttractionsController()
    {
        $request = new Request();
        $request->place = 'Hillarius';

        $controller = new ListAttractionsByPlaceController();
        $response = $controller->handle($request);

        $this->assertSame(200, $response->getData()->status);
    }

    public function testMustBeReturn200OnListAttractionsByComedianController()
    {
        $request = new Request();
        $request->replace([
            'comedianId' =>  '63a277fc7b251',
        ]);

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

    public function testMustBeReturn200OnListAttractionsByComedianNameController()
    {
        $request = new Request();
        $request->comedianName = 'Afonso';

        $controller = new ListAttractionsByComedianNameController();
        $response = $controller->handle($request);

        $this->assertSame(200, $response->getData()->status);
    }
}
