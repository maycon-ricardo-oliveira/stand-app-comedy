<?php /** @noinspection PhpUndefinedFieldInspection */

namespace App\Http\Controllers;

use App\Chore\Adapters\AuthAdapter;
use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Adapters\JwtAdapter;
use App\Chore\Adapters\MySqlAdapter;
use App\Chore\Infra\MySql\UserDAODatabase;
use App\Chore\UseCases\Auth\Auth;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @OA\Post(
     *   path="/api/v1/login",
     *   tags={"user"},
     *   operationId="AuthController@login",
     *   description="Login",
     *   security={ {"token": {} }},
     *   @OA\RequestBody(
     *     required=true,
     *     description="",
     *     @OA\JsonContent(
     *       required={"email","password"},
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
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $auth = new AuthAdapter();
        $mysql = new MySqlAdapter();
        $repo = new UserDAODatabase($mysql, $this->time);
        $useCase = new Auth($repo, $auth);

        return $this->response->successResponse($useCase->login($request->email, $request->password));
    }

    /**
     * @OA\Post(
     *   path="/api/v1/logout",
     *   tags={"user"},
     *   operationId="AuthController@logout",
     *   description="Login",
     *   security={ {"token": {} }},
     *   @OA\Response(response=200, description="Successfully logged out"),
     *   @OA\Response(response=404, description="Not found operation"),
     * )
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $auth = new AuthAdapter();

        $time = new DateTimeAdapter();
        $mysql = new MySqlAdapter();
        $repo = new UserDAODatabase($mysql, $time);
        $useCase = new Auth($repo, $auth);

        $useCase->logout();
        return $this->response->successResponse('Successfully logged out');
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        $auth = new AuthAdapter();

        $time = new DateTimeAdapter();
        $mysql = new MySqlAdapter();
        $repo = new UserDAODatabase($mysql, $time);
        $useCase = new Auth($repo, $auth);

        return $this->response->successResponse($useCase->refresh());
    }

}
