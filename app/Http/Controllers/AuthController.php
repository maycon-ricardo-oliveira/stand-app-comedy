<?php /** @noinspection PhpUndefinedFieldInspection */

namespace App\Http\Controllers;

use App\Chore\Modules\Adapters\AuthAdapter\AuthAdapter;
use App\Chore\Modules\Adapters\DateTimeAdapter\DateTimeAdapter;
use App\Chore\Modules\Adapters\HashAdapter\HashAdapter;
use App\Chore\Modules\Adapters\MySqlAdapter\MySqlAdapter;
use App\Chore\Modules\User\Infra\MySql\UserDAODatabase;
use App\Chore\Modules\User\UseCases\Auth\Auth;
use App\Mail\SendCodeResetPassword;
use Exception;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    private AuthAdapter $auth;
    private MySqlAdapter $mysql;
    private UserDAODatabase $repo;
    private Auth $useCase;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->auth = new AuthAdapter();
        $this->mysql = new MySqlAdapter();
        $this->repo = new UserDAODatabase($this->mysql, $this->time);
        $this->useCase = new Auth($this->repo, $this->auth, new HashAdapter());
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
        try {
            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ]);
            $response = $this->useCase->login($request->email, $request->password);
            return $this->response->successResponse($response);
        } catch(Exception $exception) {
            return $this->response->errorResponse($exception->getMessage());
        }

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
        $this->useCase->logout();
        return $this->response->successResponse('Successfully logged out');
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return $this->response->successResponse($this->useCase->refresh());
    }


    public function forgotPassword(Request $request): JsonResponse
    {
        try {
            $this->validate($request, [
                'email' => 'required|email|exists:users',
            ]);

            $response = $this->useCase->forgotPassword($request->email);
            Mail::to($request->email)->send(new SendCodeResetPassword($response));

            return $this->response->successResponse($response);
        } catch(Exception $exception) {
            return $this->response->errorResponse($exception->getMessage());
        }
    }

    public function checkCode(Request $request)
    {
        try {
            $request->validate([
                'token' => 'required|string|exists:password_resets',
            ]);

            $token = $this->useCase->checkCode($request->token);
            return $this->response->successResponse(['token' => $token]);

        } catch (Exception $exception) {
            return $this->response->errorResponse($exception->getMessage());
        }
    }
    public function resetPassword(Request $request)
    {
        try {
            $request->validate([
                'token' => 'required|string|exists:password_resets',
                'password' => 'required|string|min:6',
            ]);

            $this->useCase->resetPassword($request->token, $request->password);
            return $this->response->successResponse([
                'message' =>'Password has been successfully reset',
                'status' => 'ok'
            ]);

        } catch (Exception $exception) {
            return $this->response->errorResponse($exception->getMessage());
        }
    }
}
