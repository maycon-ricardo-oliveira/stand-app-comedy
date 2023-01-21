<?php

namespace App\Http\Controllers;

use App\Chore\Adapters\AuthAdapter;
use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Adapters\JwtAdapter;
use App\Chore\Adapters\MySqlAdapter;
use App\Chore\Infra\MySql\UserDAODatabase;
use App\Chore\UseCases\Login\Login;
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
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $auth = new AuthAdapter(new JwtAdapter());
        $time = new DateTimeAdapter();
        $mysql = new MySqlAdapter();
        $repo = new UserDAODatabase($mysql, $time);
        $useCase = new Login($repo, $auth);

        return $this->response->successResponse($useCase->handle($request->email, $request->password));
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

}
