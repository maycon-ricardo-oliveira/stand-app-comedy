<?php

namespace App\Http\Controllers;

use App\Chore\Modules\Adapters\DateTimeAdapter\DateTimeAdapter;
use App\Chore\Modules\Adapters\DateTimeAdapter\IDateTime;
use App\Chore\Modules\Adapters\MySqlAdapter\DBConnection;
use App\Chore\Modules\Adapters\MySqlAdapter\MySqlAdapter;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Playkids\ApiResponse\ApiResponse;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public ApiResponse $response;
    public IDateTime $time;
    public DBConnection $dbConnection;

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
        $this->time = new DateTimeAdapter();
        $this->dbConnection = new MySqlAdapter();

    }
}
