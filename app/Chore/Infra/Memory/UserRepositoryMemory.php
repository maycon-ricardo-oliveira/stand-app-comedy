<?php

namespace App\Chore\Infra\Memory;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Domain\IDateTime;
use App\Chore\Domain\IHash;
use App\Chore\Domain\User;
use App\Chore\Domain\UserRepository;
use App\Chore\Infra\UserMapper;

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
    public function register(User $userData, DateTimeAdapter $date): bool
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

    private function generateUsers(array $users)
    {
        if (empty($users)) $users = $this->dataSet();
        $this->users = $this->mapper($users);
    }
    public function dataSet() {
        return [[
            "id" => 'any_id_1',
            "name" => 'any_name',
            "email" => 'any_email_1@email.com',
            "password" => 'password',
            "remember_token" => 'remember_token'
        ],[
            "id" => 'any_id_2',
            "name" => 'any_name',
            "email" => 'any_email_2@email.com',
            "password" => 'password',
            "remember_token" => 'remember_token'
        ]];
    }
}