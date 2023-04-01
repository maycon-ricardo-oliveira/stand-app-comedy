<?php

namespace Tests\Api;

use App\Http\Controllers\FollowComedianController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tests\Feature\FeatureTestCase;

class FollowComedianControllerTest extends FeatureTestCase
{
    public function testMustBeReturn200OnFollowComedianController()
    {
        $loginResponse = $this->useLogin();

        $request = new Request();
        $request->comedianId = '63d1dc4d4b52d';

        $this->rollback($loginResponse["user"]["id"]);

        $controller = new FollowComedianController();
        $response = $controller->handle($request);

        $this->assertSame(200, $response->getData()->status);
        $this->assertIsObject($response->getData()->data);
        $this->assertSame($response->getData()->data->id, $loginResponse["user"]["id"]);

    }

    private function rollback($id)
    {
        DB::delete("delete from user_follows uf where uf.user_id = ?", [$id]);
    }

}
