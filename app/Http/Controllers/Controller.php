<?php

namespace App\Http\Controllers;

use App\Commons\ApiResponse;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected $response;

    /**
	 * @OA\Info(
	 *      version="1.0.0",
	 *      title="Base Project",
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
        $this->response = new ApiResponse();
    }
}
