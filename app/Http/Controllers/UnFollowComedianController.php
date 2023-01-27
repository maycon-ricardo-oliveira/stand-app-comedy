<?php

namespace App\Http\Controllers;

use App\Chore\Adapters\AuthAdapter;
use App\Chore\Adapters\UniqIdAdapter;
use App\Chore\Infra\MySql\ComedianDAODatabase;
use App\Chore\Infra\MySql\UserDAODatabase;
use App\Chore\UseCases\UnFollow\UnFollowComedian;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UnFollowComedianController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @OA\Post(
     *   path="/api/v1/user/unfollow",
     *   tags={"user"},
     *   operationId="UnFollowComedianController@handle",
     *   security={ {"token": {} }},
     *   @OA\RequestBody(
     *     required=true,
     *     description="",
     *     @OA\JsonContent(
     *       required={"comedianId"},
     *       @OA\Property(property="comedianId", type="string", format="", example=""),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Successful Operation",
     *     @OA\JsonContent(
     *       type="array",
     *       @OA\Items(ref="#/components/schemas/ComedianResponse")
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
        $uuid = new UniqIdAdapter();
        $userRepo = new UserDAODatabase($this->dbConnection, $this->time);
        $comedianRepo = new ComedianDAODatabase($this->dbConnection, $this->time);

        $auth = new AuthAdapter();
        $useCase = new UnFollowComedian($userRepo, $comedianRepo,$uuid);
        $response = $useCase->handle($auth->auth->user()->getAuthIdentifier(), $request->comedianId);

        return $this->response->successResponse($response);

    }

}
