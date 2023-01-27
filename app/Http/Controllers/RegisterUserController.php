<?php

namespace App\Http\Controllers;

use App\Chore\Adapters\AuthAdapter;
use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Adapters\HashAdapter;
use App\Chore\Adapters\MySqlAdapter;
use App\Chore\Adapters\UniqIdAdapter;
use App\Chore\Infra\MySql\UserDAODatabase;
use App\Chore\UseCases\Auth\Auth;
use App\Chore\UseCases\UserRegister\UserRegister;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterUserController extends Controller
{

    /**
     * @OA\Post(
     *   path="/api/v1/user/register",
     *   tags={"user"},
     *   operationId="AuthController@handle",
     *   description="Register",
     *   security={ {"token": {} }},
     *   @OA\RequestBody(
     *     required=true,
     *     description="",
     *     @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="name", type="string", format="", example="User Test"),
     *       @OA\Property(property="email", type="string", format="", example="user.test63cb4a1551081@gmail.com"),
     *       @OA\Property(property="password", type="string", format="", example="password"),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Successful Operation",
     *     @OA\JsonContent(
     *       @OA\Property(property="access_token", type="string", description="The access token"),
     *       @OA\Property(property="token_type", type="string", description="The token_type"),
     *       @OA\Property(property="expires_in", type="string", description="The expires_in"),
     *     ),
     *   ),
     *   @OA\Response(response=404, description="Not found operation"),
     * )
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function handle(Request $request): JsonResponse
    {
        $time = new DateTimeAdapter();
        $mysql = new MySqlAdapter();
        $repo = new UserDAODatabase($mysql, $time);

        $hash = new HashAdapter();
        $uuid = new UniqIdAdapter();
        $useCase = new UserRegister($repo, $hash, $uuid);

        $userData = [
            "name" => $request->name,
            "email" => $request->email,
            "password" => $request->password,
        ];

        return $this->response->successResponse($useCase->handle($userData, $time));
    }
}
