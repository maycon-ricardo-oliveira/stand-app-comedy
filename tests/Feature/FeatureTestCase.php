<?php

namespace Tests\Feature;


use App\Chore\Adapters\AuthAdapter;
use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Adapters\MySqlAdapter;
use App\Chore\Infra\MySql\UserDAODatabase;
use App\Chore\UseCases\Auth\Auth;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class FeatureTestCase extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();

        $this->time = new DateTimeAdapter();
        $this->auth = new AuthAdapter();
        $mysql = new MySqlAdapter();
        $this->repo = new UserDAODatabase($mysql, $this->time);

    }

    public function useLogin()
    {
        $email = 'user.test63cb4a1551081@gmail.com';
        $pass  = 'password';

        $useCase = new Auth($this->repo, $this->auth);
        return $useCase->login($email,$pass);

    }

}
