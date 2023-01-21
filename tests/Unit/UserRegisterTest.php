<?php

namespace Tests\Unit;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Adapters\MySqlAdapter;
use App\Chore\Infra\MySql\UserDAODatabase;
use App\Chore\UseCases\UserRegister\UserRegister;
use Tests\TestCase;

class UserRegisterTest extends TestCase
{

    public $email;

    public function setUp(): void
    {
        parent::setUp();
        $this->email = "user.test" . uniqid() . "@gmail.com";
    }

    public function testMustResisterAsUser()
    {

        $date = new DateTimeAdapter();
        $mysql = new MySqlAdapter();
        $repository = new UserDAODatabase($mysql, $date);

        $useCase = new UserRegister($repository);

        $userData = [
            "name" => "User Teste 1",
            "email" => $this->email,
            "password" => "password",
        ];

        $response = $useCase->handle($userData, $date);

        $this->assertTrue($response);
    }
    public function testMustThrowAExceptionUsingAExistentEmail()
    {

        $this->expectException(\Exception::class);
        $this->expectDeprecationMessage('This user already registered');

        $date = new DateTimeAdapter();
        $mysql = new MySqlAdapter();
        $repository = new UserDAODatabase($mysql, $date);

        $useCase = new UserRegister($repository);

        $userData = [
            "name" => "User Teste 1",
            "email" => 'user.test63cb46a0b225e@gmail.com',
            "password" => "password",
        ];

        $response = $useCase->handle($userData, $date);

        $this->assertTrue($response);
    }
}
