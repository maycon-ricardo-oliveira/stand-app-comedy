<?php

namespace Tests\Unit;

use App\Chore\Adapters\AuthAdapter;
use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Adapters\JwtAdapter;
use App\Chore\Adapters\MySqlAdapter;
use App\Chore\Infra\MySql\UserDAODatabase;
use App\Chore\UseCases\Auth\Auth;
use Exception;

class AuthTest extends UnitTestCase
{

    /**
     * @throws Exception
     */
    public function testLoginIsWorking()
    {
        $auth = new AuthAdapter(new JwtAdapter());
        $time = new DateTimeAdapter();
        $mysql = new MySqlAdapter();
        $repo = new UserDAODatabase($mysql, $time);
        $useCase = new Auth($repo, $auth);

        $email = 'user.test63cb4a1551081@gmail.com';
        $pass  = 'password';
        $response = $useCase->login($email,$pass);

        $this->assertTrue($response != false);
    }

    /**
     * @throws Exception
     */
    public function testLoginIsWrong()
    {

        $this->expectExceptionMessage('Unauthorized');
        $auth = new AuthAdapter(new JwtAdapter());

        $time = new DateTimeAdapter();
        $mysql = new MySqlAdapter();
        $repo = new UserDAODatabase($mysql, $time);
        $useCase = new Auth($repo, $auth);

        $email = 'user.test63cb4a1551081@gmail.com';
        $pass  = 'password-wrong';
        $useCase->login($email,$pass);

    }

    /**
     * @throws Exception
     */
    public function testLogoutIsWorking()
    {

        $auth = new AuthAdapter(new JwtAdapter());
        $time = new DateTimeAdapter();
        $mysql = new MySqlAdapter();
        $repo = new UserDAODatabase($mysql, $time);
        $useCase = new Auth($repo, $auth);

        $email = 'user.test63cb4a1551081@gmail.com';
        $pass  = 'password';
        $useCase->login($email,$pass);

        $this->assertTrue($useCase->logout());
    }

}
