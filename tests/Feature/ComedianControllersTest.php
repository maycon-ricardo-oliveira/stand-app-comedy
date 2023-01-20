<?php

namespace Tests\Feature;

use App\Http\Controllers\GetComedianByIdController;
use Illuminate\Http\Request;

class ComedianControllersTest extends FeatureTestCase
{

    public function testMustBeReturn200OnListAttractionsByComedianController()
    {
        $request = new Request();
        $request->comedianId = '63a277fc7b251';

        $controller = new GetComedianByIdController();
        $response = $controller->handle($request);

        $this->assertSame(200, $response->getData()->status);
        $this->assertIsArray($response->getData()->data);
    }

}
