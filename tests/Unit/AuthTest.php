<?php

namespace Tests\Unit;

use App\Chore\Modules\Adapters\AuthAdapter\AuthAdapter;
use App\Chore\Modules\Adapters\AuthAdapter\IAuth;
use App\Chore\Modules\Adapters\DateTimeAdapter\DateTimeAdapter;
use App\Chore\Modules\Adapters\DateTimeAdapter\IDateTime;
use App\Chore\Modules\Adapters\JwtAdapter\IJwt;
use App\Chore\Modules\Adapters\MySqlAdapter\MySqlAdapter;
use App\Chore\Modules\User\Entities\UserRepository;
use App\Chore\Modules\User\Infra\MySql\UserDAODatabase;
use App\Chore\Modules\User\UseCases\Auth\Auth;
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
