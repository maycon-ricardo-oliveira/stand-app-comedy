<?php

namespace Tests\Unit;

use App\Chore\Modules\Adapters\DateTimeAdapter\DateTimeAdapter;
use App\Chore\Modules\Adapters\HashAdapter\HashAdapter;
use App\Chore\Modules\User\Infra\Memory\UserRepositoryMemory;
use App\Chore\Modules\User\UseCases\ListFollowComedians\ListFollowComedians;

class ListFollowComediansTest extends UnitTestCase
{

    public function testMustReturnListFollowComedians()
    {
        $hash = new HashAdapter();
        $date = new DateTimeAdapter();
        $repository = new UserRepositoryMemory($date, $hash);

        $userId = 'any_id_3';
        $comedianId = '63d1dc4d4b52d';
        $useCase = new ListFollowComedians($repository);

        $response = $useCase->handle($userId);

        $this->assertSame($comedianId, $response[0]);
    }

    public function testMustReturnExceptionToListFollowComediansUsingANotExistentUser()
    {
        $this->expectExceptionMessage("User not found");
        $hash = new HashAdapter();
        $date = new DateTimeAdapter();
        $repository = new UserRepositoryMemory($date, $hash);

        $userId = 'not_existent_user';
        $useCase = new ListFollowComedians($repository);

        $useCase->handle($userId);

    }

}
