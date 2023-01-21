<?php

namespace Tests\Unit;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Adapters\MySqlAdapter;
use App\Chore\Infra\MySql\UserDAODatabase;
use App\Chore\UseCases\Login\Login;

class LoginTest extends UnitTestCase
{
    public function testLoginIsCorrect()
    {

        $time = new DateTimeAdapter();
        $mysql = new MySqlAdapter();
        $repo = new UserDAODatabase($mysql, $time);
        $useCase = new Login($repo);

        $email = 'user.test63cb4a1551081@gmail.com';
        $pass  = 'password';
        $response = $useCase->handle($email,$pass);

        $this->assertTrue($response);
    }

    public function testLoginIsWrong()
    {

        $time = new DateTimeAdapter();
        $mysql = new MySqlAdapter();
        $repo = new UserDAODatabase($mysql, $time);
        $useCase = new Login($repo);

        $email = 'user.test63cb4a1551081@gmail.com';
        $pass  = 'password-wrong';
        $response = $useCase->handle($email,$pass);

        $this->assertFalse($response);

    }

}
