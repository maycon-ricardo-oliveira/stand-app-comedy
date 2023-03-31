<?php

namespace Tests\Feature;


use App\Chore\Modules\Adapters\AuthAdapter\AuthAdapter;
use App\Chore\Modules\Adapters\DateTimeAdapter\DateTimeAdapter;
use App\Chore\Modules\Adapters\MySqlAdapter\MySqlAdapter;
use App\Chore\Modules\User\Infra\MySql\UserDAODatabase;
use App\Chore\Modules\User\UseCases\Auth\Auth;
use Tests\TestCase;

class FeatureTestCase extends TestCase
{

    public MySqlAdapter $mysql;
    public UserDAODatabase $repo;

    public function setUp(): void
    {
        parent::setUp();

        $this->time = new DateTimeAdapter();
        $this->auth = new AuthAdapter();
        $this->mysql = new MySqlAdapter();
        $this->repo = new UserDAODatabase($this->mysql, $this->time);

    }

    public function useLogin()
    {
        $email = 'user.test63cb4a1551081@gmail.com';
        $pass  = 'password';

        $useCase = new Auth($this->repo, $this->auth);
        return $useCase->login($email,$pass);

    }

}
