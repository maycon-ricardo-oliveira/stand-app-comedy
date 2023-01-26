<?php

namespace Tests\Unit;

use App\Chore\Adapters\AuthAdapter;
use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Adapters\JwtAdapter;
use App\Chore\Adapters\MySqlAdapter;
use App\Chore\Domain\IAuth;
use App\Chore\Domain\IDateTime;
use App\Chore\Domain\IJwt;
use App\Chore\Domain\UserRepository;
use App\Chore\Infra\MySql\UserDAODatabase;
use App\Chore\UseCases\Auth\Auth;
use Exception;

class AuthTest extends UnitTestCase
{
    public IJwt $jwt;
    public IAuth $auth;
    public UserRepository $repo;
    public IDateTime $time;

    public function setUp(): void
    {
        parent::setUp();

        $this->time = new DateTimeAdapter();
        $this->auth = new AuthAdapter();
        $mysql = new MySqlAdapter();
        $this->repo = new UserDAODatabase($mysql, $this->time);

    }

    /**
     * @throws Exception
     */
    public function testLoginIsWorking()
    {

        $useCase = new Auth($this->repo, $this->auth);

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

        $useCase = new Auth($this->repo, $this->auth);

        $email = 'user.test63cb4a1551081@gmail.com';
        $pass  = 'password-wrong';
        $useCase->login($email,$pass);

    }

    /**
     * @throws Exception
     */
    public function testLogoutIsWorking()
    {

        $useCase = new Auth($this->repo, $this->auth);

        $email = 'user.test63cb4a1551081@gmail.com';
        $pass  = 'password';

        $useCase->login($email,$pass);

        $this->assertTrue($useCase->logout());
    }
    public function testRefreshTokenIsWorking()
    {

        $email = 'user.test63cb4a1551081@gmail.com';
        $pass  = 'password';

        $useCase = new Auth($this->repo, $this->auth);
        $loginResponse = $useCase->login($email,$pass);
        $loginToken = $loginResponse["access_token"];

        $refreshResponse = $useCase->refresh();
        $refreshToken = $refreshResponse["access_token"];

        $this->assertNotSame($loginToken, $refreshToken);
        $this->assertSame($loginResponse["user"]["id"], $refreshResponse["user"]["id"]);

    }

}
