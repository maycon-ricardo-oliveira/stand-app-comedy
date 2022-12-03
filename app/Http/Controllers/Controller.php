<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Mayconoliveira\SimpleResponse\ApiResponse;

class Controller extends BaseController
{
    protected $response;

    /**
	 * @OA\Info(
	 *      version="1.0.0",
	 *      title="StandApp Project",
	 *      description="Documentation API",
	 * )
	 * @OA\Tag(
     *     name="example",
     *     description="Documentation API"
     * )
     *
     */
    public function __construct()
    {
        $this->response = new ApiResponse(env('APP_SLUG'));
    }
}
