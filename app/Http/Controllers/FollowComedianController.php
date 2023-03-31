<?php

namespace App\Http\Controllers;

use App\Chore\Modules\Adapters\AuthAdapter\AuthAdapter;
use App\Chore\Modules\Adapters\UuidAdapter\UniqIdAdapter;
use App\Chore\Modules\Comedians\Infra\MySql\ComedianDAODatabase;
use App\Chore\Modules\User\Infra\MySql\UserDAODatabase;
use App\Chore\Modules\User\UseCases\Follow\FollowComedian;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FollowComedianController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @OA\Post(
     *   path="/api/v1/user/follow",
     *   tags={"user"},
     *   operationId="FollowComedianController@handle",
     *   security={ {"token": {} }},
     *   @OA\RequestBody(
     *     required=true,
     *     description="",
     *     @OA\JsonContent(
     *       required={"comedianId"},
     *       @OA\Property(property="comedianId", type="string", format="", example="63d1c98de5cea"),
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
        try {

            $uuid = new UniqIdAdapter();
            $userRepo = new UserDAODatabase($this->dbConnection, $this->time);
            $comedianRepo = new ComedianDAODatabase($this->dbConnection, $this->time);

            $auth = new AuthAdapter();
            $useCase = new FollowComedian($userRepo, $comedianRepo,$uuid);
            $response = $useCase->handle($auth->auth->user()->getAuthIdentifier(), $request->comedianId);

            return $this->response->successResponse($response);

        } catch(\Exception $exception) {
            return $this->response->badRequestResponse($exception->getMessage());
        }

    }

}
