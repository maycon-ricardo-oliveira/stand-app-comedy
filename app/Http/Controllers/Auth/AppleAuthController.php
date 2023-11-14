<?php

namespace App\Http\Controllers\Auth;


use App\Chore\Modules\Adapters\UuidAdapter\UniqIdAdapter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AppleAuthController extends Controller
{

    public function handleAppleCallback()
    {
        try {

            $user = Socialite::driver('apple')->user();
            $token = $user->token;
            $refreshToken = $user->refreshToken;
            $expiresIn = $user->expiresIn;

            $findUser = User::where('apple_id', $user->id)->first();

            if ($findUser) {
                Auth::login($findUser);
                return [
                    'access_token' => $token,
                    'refreshToken' => $refreshToken,
                    'token_type' => 'bearer',
                    'expires_in' => $expiresIn,
                    'user' => [
                        'id' => $findUser->id,
                        'name' => $findUser->name,
                    ]
                ];
            } else {
                $uuid = new UniqIdAdapter();
                $newUser = User::create([
                    'id' => $uuid->id(),
                    'name' => $user->name,
                    'email' => $user->email,
                    'apple_id'=> $user->id,
                    'password' => encrypt('')
                ]);

                Auth::login($newUser);
                return $this->response->successResponse([
                    'access_token' => $token,
                    'refreshToken' => $refreshToken,
                    'token_type' => 'bearer',
                    'expires_in' => $expiresIn,
                    'user' => [
                        'id' => $newUser->id,
                        'name' => $newUser->name,
                    ]
                ]);
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function redirectToApple()
    {
        return Socialite::driver('apple')->redirect();
    }

}
