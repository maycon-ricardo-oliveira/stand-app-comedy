<?php

namespace Tests\Feature;

use App\Http\Controllers\RegisterAttractionController;
use Illuminate\Http\Request;

class RegisterAttractionControllerTest extends FeatureTestCase
{
    public function testMustBeReturn200OnListAttractionsByComedianController()
    {
        $request = new Request();
        $request->title = "O Problema é meu";
        $request->date = "2023-02-21 22:50:59";
        $request->status = 'draft';
        $request->comedianId = '63d1dc4d4b52d';
        $request->placeId = '63d332d4be678';
        $request->ownerId = '63d1c98e22ccb';
        $request->duration = '180';

        $controller = new RegisterAttractionController();
        $response = $controller->handle($request);

        $this->assertSame(200, $response->getData()->status);
        $this->assertIsObject($response->getData()->data);
        $this->assertSame($response->getData()->data->title, $request->title);
    }

}