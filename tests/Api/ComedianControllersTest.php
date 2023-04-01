<?php

namespace Tests\Api;

use App\Http\Controllers\GetComedianByIdController;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;

class ComedianControllersTest extends ApiTestCase
{

    use DatabaseTransactions;

    public function testMustBeReturn200OnListAttractionsByComedianController()
    {
        $request = new Request();
        $request->comedianId = '63d1dc4d4b52d';

        $controller = new GetComedianByIdController();
        $response = $controller->handle($request);

        $this->assertSame(200, $response->getData()->status);
        $this->assertIsObject($response->getData()->data);
        $this->assertSame($response->getData()->data->id, $request->comedianId);
    }

}
