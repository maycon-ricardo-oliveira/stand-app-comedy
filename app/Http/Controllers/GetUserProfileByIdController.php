<?php

namespace App\Http\Controllers;

use App\Chore\Modules\Adapters\MySqlAdapter\MySqlAdapter;
use App\Chore\Modules\Comedians\Infra\MySql\ComedianDAODatabase;
use App\Chore\Modules\User\Infra\MySql\UserDAODatabase;
use App\Chore\Modules\User\UseCases\GetUserProfile\GetUserProfileById;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetUserProfileByIdController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @OA\Get(
     *   path="/api/v1/user/{userId}",
     *   tags={"user"},
     *   operationId="GetUserProfileByIdController@handle",
     *   description="Returns details by user id",
     *   security={ {"token": {} }},
     *   @OA\Parameter(
     *     name="userId", in="path", example="63d1c98e22ccb",
     *     description="User id",
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Successful Operation",
     *     @OA\JsonContent(
     *       type="array",
     *       @OA\Items(ref="#/components/schemas/UserResponse")
     *     ),
     *   ),
     *   @OA\Response(response=404, description="Not found operation"),
     * )
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function handle(Request $request)
    {

        $mySql = new MySqlAdapter();
        $comedianRepo = new ComedianDAODatabase($mySql, $this->time);
        $repo = new UserDAODatabase($this->dbConnection, $this->time);
        $useCase = new GetUserProfileById($repo, $comedianRepo);

        $response = $useCase->handle($request->userId);

        return $this->response->successResponse($response);

    }

}
