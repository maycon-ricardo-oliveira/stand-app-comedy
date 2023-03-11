<?php

namespace Tests\Feature;

use App\Http\Controllers\RegisterAttractionController;
use App\Http\Controllers\RegisterUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterUserControllerTest extends FeatureTestCase
{
    public function testMustBeReturn200OnListAttractionsByComedianController()
    {
        $request = new Request();
        $request->name = "New User Test";
        $request->email = "new.user@test.com";
        $request->password = "password";

        $this->rollback($request->email);

        $controller = new RegisterUserController();
        $response = $controller->handle($request);

        $this->assertSame(200, $response->getData()->status);
        $this->assertIsObject($response->getData()->data);
        $this->assertSame($response->getData()->data->name, $request->name);
        $this->assertNotSame($response->getData()->data->password, $request->password);
    }

    private function rollback($email)
    {
        DB::delete("delete from users u where u.email = ?", [$email]);
    }
}
