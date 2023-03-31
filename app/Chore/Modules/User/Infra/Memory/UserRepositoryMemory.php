<?php

namespace App\Chore\Modules\User\Infra\Memory;

use App\Chore\Modules\Adapters\DateTimeAdapter\IDateTime;
use App\Chore\Modules\Adapters\HashAdapter\IHash;
use App\Chore\Modules\Comedians\Entities\Comedian;
use App\Chore\Modules\User\Entities\User;
use App\Chore\Modules\User\Entities\UserRepository;
use App\Chore\Modules\User\Infra\UserMapper;

class UserRepositoryMemory extends UserMapper implements UserRepository
{

    public array $users;

    public IDateTime $time;
    public IHash $bcrypt;

    /**
     * @param IDateTime $time
     * @param IHash $bcrypt
     * @param array $users
     */
    public function __construct(IDateTime $time, IHash $bcrypt, array $users = [])
    {
        parent::__construct();
        $this->bcrypt = $bcrypt;
        $this->time = $time;
        $this->generateUsers($users);
    }
    public function register(User $userData, IDateTime $date): bool
    {

        $user = $this->findUserByEmail($userData->email);

        if (count($user) != 0) {
            throw new \Exception('This user already registered');
        }

        $this->users[] = $userData;
        return true;
    }

    public function findUserByEmail(string $email)
    {
        $response = array_values(array_filter($this->users, function ($user) use ($email) {
            return $user->email == $email;
        }));
        return $response;
    }

    public function findUserById(string $id): ?User
    {
        $response = array_values(array_filter($this->users, function ($user) use ($id) {
            return $user->id == $id;
        }));
        return count($response) == 0 ? null : $response[0];
    }

    private function generateUsers(array $users)
    {
        if (empty($users)) $users = $this->dataSet();
        $this->users = $this->mapper($users);
    }

    public function followComedian(User $user, Comedian $comedian, string $id)
    {
        if (count($user->followingComedians) == 0) {
            $user->followingComedians[] = $comedian;
            return $user;
        }

        foreach ($user->followingComedians as $followingComedian) {
            if ($followingComedian->id == $comedian->id) {
                $user->followingComedians[] = $comedian;
                return $user;
            }
        }

        return null;
    }

    public function dataSet() {
        return [[
            "id" => 'any_id_1',
            "name" => 'any_name',
            "email" => 'any_email_1@email.com',
            "password" => 'password',
            "remember_token" => 'remember_token',
            "followingComedians" => []
        ],[
            "id" => 'any_id_2',
            "name" => 'any_name',
            "email" => 'any_email_2@email.com',
            "password" => 'password',
            "remember_token" => 'remember_token',
            "followingComedians" => "63d1dc4d4b52d,any_id_2"
        ],[
            "id" => 'any_id_3',
            "name" => 'any_name',
            "email" => 'user.test63cb4a1551081@gmail.com',
            "password" => 'password',
            "remember_token" => 'remember_token',
            "followingComedians" => "63d1dc4d4b52d"
        ]];
    }

    public function checkIfIsFollowAComedian(User $user, Comedian $comedian)
    {
        // TODO: Implement getFollows() method.
    }

    public function unFollowComedian(User $user, Comedian $comedian)
    {
        if (count($user->followingComedians) == 0) {
            return $user;
        }

        foreach ($user->followingComedians as $key => $followingComedian) {
                if ($followingComedian->id == $comedian->id) {
                unset($user->followingComedians[$key]);
                return $user;
            }
        }

        return null;
    }

    public function listFollowComedians(User $user)
    {
        $response = array_values(array_filter($this->users, function ($item) use ($user) {
            return $item->id == $user->id;
        }));

        return count($response) == 0 ? null : $response[0]->followingComedians;

    }
}
