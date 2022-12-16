<?php

namespace Tests\Feature;

use App\Http\Controllers\ListAttractionController;
use Illuminate\Http\Request;

class ListAudiobooksBySubscriptionControllerTest extends FeatureTestCase
{

    public function testMustBeReturn200OnListAttractionsController()
    {

        $request = new Request();
        $request->place = 'Hillarius';

        $controller = new ListAttractionController();
        $response = $controller->handle($request);

        $this->assertSame(200, $response->getData()->status);

    }

}
