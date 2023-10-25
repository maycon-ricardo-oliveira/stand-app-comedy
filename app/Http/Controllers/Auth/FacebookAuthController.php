<?php

namespace App\Http\Controllers\Auth;


use App\Chore\Modules\Adapters\UuidAdapter\UniqIdAdapter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class FacebookAuthController extends Controller
{

    public function handleFacebookCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();
            $token = $user->token;
            $refreshToken = $user->refreshToken;
            $expiresIn = $user->expiresIn;

            $finduser = User::where('facebook_id', $user->id)->first();

            if ($finduser) {
                Auth::login($finduser);
                return [
                    'access_token' => $token,
                    'refreshToken' => $refreshToken,
                    'token_type' => 'bearer',
                    'expires_in' => $expiresIn,
                    'user' => [
                        'id' => $finduser->id,
                        'name' => $finduser->name,
                    ]
                ];
            } else {
                $uuid = new UniqIdAdapter();
                $newUser = User::create([
                    'id' => $uuid->id(),
                    'name' => $user->name,
                    'email' => $user->email,
                    'facebook_id'=> $user->id,
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

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

}
