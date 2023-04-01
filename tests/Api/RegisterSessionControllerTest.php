<?php

namespace Tests\Api;


use App\Http\Controllers\RegisterSessionController;
use Illuminate\Http\Request;

class RegisterSessionControllerTest extends ApiTestCase
{

    public function testMustBeReturn200OnListAttractionsByComedianController()
    {

        $request = new Request();
        $request->attractionId = '63d332d50ff63';
        $request->userId = '63d1c98e22ccb';
        $request->tickets = 10;
        $request->ticketsSold = 0;
        $request->ticketsValidated = 0;
        $request->startAt = '21:00:00';
        $request->finishAt = '22:00:00';
        $request->status = 'draft';

        $controller = new RegisterSessionController();
        $response = $controller->handle($request);

        $this->assertSame(200, $response->getData()->status);
        $this->assertIsObject($response->getData()->data);
        $this->assertSame($response->getData()->data->attractionId, $request->attractionId);
    }

}
