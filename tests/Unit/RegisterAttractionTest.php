<?php

namespace Tests\Unit;

use App\Chore\Modules\Adapters\DateTimeAdapter\DateTimeAdapter;
use App\Chore\Modules\Adapters\HashAdapter\HashAdapter;
use App\Chore\Modules\Adapters\UuidAdapter\UniqIdAdapter;
use App\Chore\Modules\Attractions\Infra\Memory\AttractionRepositoryMemory;
use App\Chore\Modules\Attractions\UseCases\RegisterAttraction\RegisterAttraction;
use App\Chore\Modules\Comedians\Infra\Memory\ComedianRepositoryMemory;
use App\Chore\Modules\Places\Infra\Memory\PlaceRepositoryMemory;
use App\Chore\Modules\User\Infra\Memory\UserRepositoryMemory;
use Exception;

class RegisterAttractionTest extends UnitTestCase
{

    private PlaceRepositoryMemory $placeRepo;
    private AttractionRepositoryMemory $attractionRepo;
    private UserRepositoryMemory $userRepo;
    private ComedianRepositoryMemory $comedianRepo;
    private UniqIdAdapter $uuid;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $date = new DateTimeAdapter();
        $hash = new HashAdapter();

        $this->attractionRepo = new AttractionRepositoryMemory($date);
        $this->userRepo = new UserRepositoryMemory($date, $hash);
        $this->placeRepo = new PlaceRepositoryMemory();
        $this->comedianRepo = new ComedianRepositoryMemory();
        $this->uuid = new UniqIdAdapter();
    }

    /**
     * @throws Exception
     */
    public function testMustRegisterAttraction()
    {
        $date = new DateTimeAdapter();
        $useCase = new RegisterAttraction(
            $this->attractionRepo,
            $this->comedianRepo,
            $this->placeRepo,
            $this->userRepo,
            $this->uuid
        );

        $attraction = [
            "title" => "any_title",
            "date" => "2023-01-09 00:00:00",
            "status" => "draft",
            "comedianId" => "any_id_1",
            "duration" => '180',
            "placeId" => "any_id",
            "ownerId" => "any_id_3",
        ];

        $response = $useCase->handle($attraction, $date);

        $this->assertSame($response->title, $attraction["title"]);
    }

    /**
     * @throws Exception
     */
    public function testMustReturnExceptionToRegisterAttractionUsingANotExistentComedian()
    {
        $this->expectExceptionMessage("Comedian not found");

        $date = new DateTimeAdapter();
        $useCase = new RegisterAttraction(
            $this->attractionRepo,
            $this->comedianRepo,
            $this->placeRepo,
            $this->userRepo,
            $this->uuid
        );

        $attraction = [
            "title" => "any_title",
            "date" => "2023-01-09 00:00:00",
            "status" => "draft",
            "comedianId" => "not_existent_id",
            "duration" => '180',
            "placeId" => "any_id",
            "ownerId" => "any_id_3",
        ];

        $useCase->handle($attraction, $date);

    }

    public function testMustReturnExceptionToRegisterAttractionUsingANotExistentPlace()
    {
        $this->expectExceptionMessage("Place not found");

        $date = new DateTimeAdapter();
        $useCase = new RegisterAttraction(
            $this->attractionRepo,
            $this->comedianRepo,
            $this->placeRepo,
            $this->userRepo,
            $this->uuid
        );

        $attraction = [
            "title" => "any_title",
            "date" => "2023-01-09 00:00:00",
            "status" => "draft",
            "comedianId" => "any_id_1",
            "duration" => '180',
            "placeId" => "not_existent_id",
            "ownerId" => "any_id_3",
        ];

        $useCase->handle($attraction, $date);

    }
    public function testMustReturnExceptionToRegisterAttractionUsingANotExistentUser()
    {
        $this->expectExceptionMessage("User not found");

        $date = new DateTimeAdapter();
        $useCase = new RegisterAttraction(
            $this->attractionRepo,
            $this->comedianRepo,
            $this->placeRepo,
            $this->userRepo,
            $this->uuid
        );

        $attraction = [
            "title" => "any_title",
            "date" => "2023-01-09 00:00:00",
            "status" => "draft",
            "comedianId" => "any_id_1",
            "duration" => '180',
            "placeId" => "any_id",
            "ownerId" => "not_existent_id",
        ];

        $useCase->handle($attraction, $date);

    }

}
