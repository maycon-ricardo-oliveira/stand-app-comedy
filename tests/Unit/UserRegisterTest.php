<?php

namespace Tests\Unit;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Adapters\HashAdapter;
use App\Chore\Adapters\MySqlAdapter;
use App\Chore\Adapters\UniqIdAdapter;
use App\Chore\Infra\Memory\UserRepositoryMemory;
use App\Chore\Infra\MySql\UserDAODatabase;
use App\Chore\UseCases\UserRegister\UserRegister;
use Illuminate\Hashing\BcryptHasher;
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

        $bcrypt = new HashAdapter();
        $date = new DateTimeAdapter();
        $repository = new UserRepositoryMemory($date, $bcrypt);
        $hashAdapter = new HashAdapter();
        $uuidAdapter = new UniqIdAdapter();
        $useCase = new UserRegister($repository, $hashAdapter, $uuidAdapter);

        $userData = [
            "name" => "User Teste 1",
            "email" => $this->email,
            "password" => "password",
        ];

        $response = $useCase->handle($userData, $date);

        $this->assertSame($response[0]->name, $userData['name']);
        $this->assertNotEquals($response[0]->password, $userData['password']);
    }

    public function testMustThrowAExceptionUsingAExistentEmail()
    {

        $this->expectException(\Exception::class);
        $this->expectDeprecationMessage('This user already registered');

        $bcrypt = new HashAdapter();
        $date = new DateTimeAdapter();
        $hashAdapter = new HashAdapter();
        $uuidAdapter = new UniqIdAdapter();
        $repository = new UserRepositoryMemory($date, $bcrypt);

        $useCase = new UserRegister($repository, $hashAdapter, $uuidAdapter);

        $userData = [
            "name" => "User Teste 1",
            "email" => 'any_email_1@email.com',
            "password" => "password",
        ];

        $response = $useCase->handle($userData, $date);

        $this->assertTrue($response[0]);
    }
}
