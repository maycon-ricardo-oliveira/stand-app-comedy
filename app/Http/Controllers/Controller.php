<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Playkids\ApiResponse\ApiResponse;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $response;

    /**
     * @OA\Info(
     *   version="1.0.0",
     *   title="StandApp Documentation",
     *   description="Documentation API",
     * )
	 * @OA\Tag(
     *   name="public",
     *   description="Public Routes"
     * )
     */
    public function __construct()
    {
        $this->response = new ApiResponse(env('APP_SLUG'));
    }
}
