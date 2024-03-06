<?php

namespace App\Chore\Modules\User\UseCases\Auth;

use App\Chore\Modules\Adapters\AuthAdapter\IAuth;
use App\Chore\Modules\Adapters\HashAdapter\IHash;
use App\Chore\Modules\Adapters\JwtAdapter\JwtAdapter;
use App\Chore\Modules\User\Entities\User;
use App\Chore\Modules\User\Entities\UserRepository;
use App\Models\PasswordResets;
use App\Models\User as UserModel;

class Auth
{
    public UserRepository $userRepository;
    public IAuth $auth;
    private IHash $bcrypt;

    public function __construct(UserRepository $userRepository, IAuth $auth, IHash $bcrypt)
    {
        $this->userRepository = $userRepository;
        $this->auth = $auth;
        $this->bcrypt = $bcrypt;
    }

    public function login($email, $password)
    {

        $user = $this->userRepository->findUserByEmail($email);

        if (!$user instanceof User) {
            throw new \Exception("Password or Email Incorrect");
        }

        if (!$token = $this->auth->auth->attempt(['email' => $email, 'password' => $password])) {
            throw new \Exception("Unauthorized");
        }

        $jwt = new JwtAdapter();
        return $jwt->createToken($user, $token);
    }

    public function logout(): bool
    {
        $this->auth->logout();
        return true;
    }

    /**
     * @throws \Exception
     */
    public function refresh()
    {
        $user = $this->userRepository->findUserById($this->auth->user()->getAuthIdentifier());

        if (!$user instanceof User) {
            throw new \Exception("Email does not exist");
        }

        $token = $this->auth->refresh($user);
        $jwt = new JwtAdapter();
        return $jwt->createToken($user, $token);
    }

    public function forgotPassword(string $email): PasswordResets
    {

        PasswordResets::where('email', $email)->delete();
        $code = mt_rand(100000, 999999);

        $codeData = PasswordResets::create([
            "email" => $email,
            "token" => $code,
        ]);

        return $codeData;
    }

    /**
     * @throws \Exception
     */
    public function checkCode(string $token)
    {
        $passwordReset = PasswordResets::firstWhere('token', $token);

        if ($passwordReset->created_at > now()->addHour()) {
            $passwordReset->delete();
            throw new \Exception('Expired Token');
        }

        return $passwordReset->token;
    }

    /**
     * @throws \Exception
     */
    public function resetPassword(string $token, string $password)
    {
        $passwordReset = PasswordResets::firstWhere('token', $token);

        if ($passwordReset->created_at > now()->addHour()) {
            $passwordReset->delete();
            throw new \Exception('Expired Token');
        }

        $encriptedPassword = $this->bcrypt->make($password);

        $user = UserModel::firstWhere('email', $passwordReset->email);
        $user->update(["password" => $encriptedPassword]);

        $passwordReset->delete();
        return true;
    }
}
