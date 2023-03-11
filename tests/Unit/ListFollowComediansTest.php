<?php

namespace Tests\Unit;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Adapters\HashAdapter;
use App\Chore\Infra\Memory\UserRepositoryMemory;
use App\Chore\UseCases\ListFollowComedians\ListFollowComedians;
use App\Chore\UseCases\RegisterAttraction\RegisterAttraction;
use Illuminate\Hashing\BcryptHasher;

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
