<?php

namespace Tests\Unit;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Adapters\HashAdapter;
use App\Chore\Adapters\UniqIdAdapter;
use App\Chore\Infra\Memory\ComedianRepositoryMemory;
use App\Chore\Infra\Memory\UserRepositoryMemory;
use App\Chore\UseCases\Follow\FollowComedian;
use App\Chore\UseCases\UnFollow\UnFollowComedian;

class FollowComedianTest extends UnitTestCase
{
    /**
     * @throws \Exception
     */
    public function testMustFollowAComedian()
    {

        $bcrypt = new HashAdapter();
        $date = new DateTimeAdapter();
        $userRepo = new UserRepositoryMemory($date, $bcrypt);
        $comedianRepo = new ComedianRepositoryMemory();
        $uuid = new UniqIdAdapter();

        $anyUserId = 'any_id_1';
        $anyComedianId = 'any_id_2';

        $useCase = new FollowComedian($userRepo, $comedianRepo, $uuid);

        $response = $useCase->handle($anyUserId, $anyComedianId);

        $this->assertNotEmpty($response->followingComedians);
        $this->assertSame($response->followingComedians[0]->id, $anyComedianId);

    }

    public function testMustReturnExceptionUnFollowANotExistentComedian()
    {
        $this->expectExceptionMessage("Comedian does not exist");

        $bcrypt = new HashAdapter();
        $date = new DateTimeAdapter();
        $userRepo = new UserRepositoryMemory($date, $bcrypt);
        $comedianRepo = new ComedianRepositoryMemory();
        $uuid = new UniqIdAdapter();

        $anyUserId = 'any_id_1';
        $anyComedianId = 'not_exixtent_id';

        $useCase = new FollowComedian($userRepo, $comedianRepo, $uuid);
        $useCase->handle($anyUserId, $anyComedianId);

    }

    public function testMustReturnExceptionUnFollowANotExistentUser()
    {
        $this->expectExceptionMessage("User does not exist");

        $bcrypt = new HashAdapter();
        $date = new DateTimeAdapter();
        $userRepo = new UserRepositoryMemory($date, $bcrypt);
        $comedianRepo = new ComedianRepositoryMemory();
        $uuid = new UniqIdAdapter();

        $anyUserId = 'not_exixtent_id';
        $anyComedianId = 'any_id_1';

        $useCase = new FollowComedian($userRepo, $comedianRepo, $uuid);
        $useCase->handle($anyUserId, $anyComedianId);

    }

}