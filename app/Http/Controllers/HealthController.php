<?php

namespace App\Http\Controllers;

class HealthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @OA\Get(
     *     path="/api/health",
     *     tags={"health"},
     *     operationId="healthCheck",
     *     description="Returns if apllication is running.",
     *     security={ {"token": {} }},
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=404, description="Not found operation"),
     * )
     */
    public function healthCheck ()
    {
        return $this->response->successResponse('Up and Running');
    }
}
