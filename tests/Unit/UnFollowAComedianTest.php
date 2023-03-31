<?php

namespace Tests\Unit;

use App\Chore\Modules\Adapters\DateTimeAdapter\DateTimeAdapter;
use App\Chore\Modules\Adapters\HashAdapter\HashAdapter;
use App\Chore\Modules\Adapters\UuidAdapter\UniqIdAdapter;
use App\Chore\Modules\Comedians\Infra\Memory\ComedianRepositoryMemory;
use App\Chore\Modules\User\Infra\Memory\UserRepositoryMemory;
use App\Chore\Modules\User\UseCases\Follow\FollowComedian;
use App\Chore\Modules\User\UseCases\UnFollow\UnFollowComedian;

class UnFollowAComedianTest extends UnitTestCase
{
    public function testMustUnFollowAComedian()
    {

        $bcrypt = new HashAdapter();
        $date = new DateTimeAdapter();
        $userRepo = new UserRepositoryMemory($date, $bcrypt);
        $comedianRepo = new ComedianRepositoryMemory();

        $anyUserId = 'any_id_1';
        $anyComedianId = 'any_id_2';

        $useCase = new UnFollowComedian($userRepo, $comedianRepo);

        $response = $useCase->handle($anyUserId, $anyComedianId);

        $this->assertEmpty($response->followingComedians);

    }

    public function testMustReturnExceptionUnFollowANotExistentComedian()
    {
        $this->expectExceptionMessage("Comedian does not exist");

        $bcrypt = new HashAdapter();
        $date = new DateTimeAdapter();
        $userRepo = new UserRepositoryMemory($date, $bcrypt);
        $comedianRepo = new ComedianRepositoryMemory();

        $anyUserId = 'any_id_1';
        $anyComedianId = 'not_exixtent_id';

        $useCase = new UnFollowComedian($userRepo, $comedianRepo);
        $useCase->handle($anyUserId, $anyComedianId);

    }

    public function testMustReturnExceptionUnFollowANotExistentUser()
    {
        $this->expectExceptionMessage("User does not exist");

        $bcrypt = new HashAdapter();
        $date = new DateTimeAdapter();
        $userRepo = new UserRepositoryMemory($date, $bcrypt);
        $comedianRepo = new ComedianRepositoryMemory();

        $anyUserId = 'not_exixtent_id';
        $anyComedianId = 'any_id_1';

        $useCase = new UnFollowComedian($userRepo, $comedianRepo);
        $useCase->handle($anyUserId, $anyComedianId);

    }

    public function testMustFollowAndUnFollowAComedian()
    {

        $bcrypt = new HashAdapter();
        $date = new DateTimeAdapter();
        $userRepo = new UserRepositoryMemory($date, $bcrypt);
        $comedianRepo = new ComedianRepositoryMemory();
        $uuid = new UniqIdAdapter();

        $anyUserId = 'any_id_1';
        $anyComedianId = 'any_id_2';

        $followCase = new FollowComedian($userRepo, $comedianRepo, $uuid);
        $unFollowCase = new UnFollowComedian($userRepo, $comedianRepo);

        $followResponse = $followCase->handle($anyUserId, $anyComedianId);
        $this->assertNotEmpty($followResponse->followingComedians);
        $this->assertNotEmpty($followResponse->followingComedians);
        $this->assertSame($followResponse->followingComedians[0]->id, $anyComedianId);

        $unFollowResponse = $unFollowCase->handle($anyUserId, $anyComedianId);

        $this->assertEmpty($unFollowResponse->followingComedians);
    }
}
