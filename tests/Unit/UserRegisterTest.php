<?php

namespace Tests\Unit;

use App\Chore\Modules\Adapters\DateTimeAdapter\DateTimeAdapter;
use App\Chore\Modules\Adapters\HashAdapter\HashAdapter;
use App\Chore\Modules\Adapters\UuidAdapter\UniqIdAdapter;
use App\Chore\Modules\Comedians\Infra\Memory\ComedianRepositoryMemory;
use App\Chore\Modules\User\Infra\Memory\UserRepositoryMemory;
use App\Chore\Modules\User\UseCases\GetUserProfile\GetUserProfileById;
use App\Chore\Modules\User\UseCases\UserRegister\UserRegister;
use App\Chore\Modules\User\UserAlreadyRegisteredException;
use Exception;
use Tests\TestCase;

class UserRegisterTest extends TestCase
{

    public $email;

    public function setUp(): void
    {
        parent::setUp();
        $this->email = "user.test" . uniqid() . "@gmail.com";
    }

    /**
     * @throws UserAlreadyRegisteredException
     */
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

    public function testMustReturnAnUserProfile()
    {
        $bcrypt = new HashAdapter();
        $date = new DateTimeAdapter();
        $repository = new UserRepositoryMemory($date, $bcrypt);
        $hashAdapter = new HashAdapter();
        $uuidAdapter = new UniqIdAdapter();
        $register = new UserRegister($repository, $hashAdapter, $uuidAdapter);
        $comedianRepo = new ComedianRepositoryMemory();
        $useCase = new GetUserProfileById($repository, $comedianRepo);

        $userData = [
            "name" => "User Teste 1",
            "email" => $this->email,
            "password" => "password",
        ];

        $response = $register->handle($userData, $date);
        $userProfile = $useCase->handle($response[0]->id);

        $this->assertSame($response[0]->name, $userData['name']);
        $this->assertNotEquals($response[0]->password, $userData['password']);

        $this->assertSame($userProfile->user->id,$response[0]->id);

    }


    /**
     * @return void
     * @throws UserAlreadyRegisteredException
     */
    public function testMustThrowAExceptionUsingAExistentEmail()
    {

        $this->expectException(UserAlreadyRegisteredException::class);

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
