<?php

namespace Tests\Unit;

use App\Chore\Modules\Adapters\DateTimeAdapter\DateTimeAdapter;
use App\Chore\Modules\Adapters\HashAdapter\HashAdapter;
use App\Chore\Modules\Adapters\UuidAdapter\UniqIdAdapter;
use App\Chore\Modules\Attractions\Entities\Attraction;
use App\Chore\Modules\Attractions\Infra\Memory\AttractionRepositoryMemory;
use App\Chore\Modules\Attractions\UseCases\RegisterAttraction\RegisterAttraction;
use App\Chore\Modules\Comedians\Infra\Memory\ComedianRepositoryMemory;
use App\Chore\Modules\Places\Infra\Memory\PlaceRepositoryMemory;
use App\Chore\Modules\Sessions\Entities\Session;
use App\Chore\Modules\Sessions\Infra\Memory\SessionRepositoryMemory;
use App\Chore\Modules\Sessions\UseCases\RegisterSession\RegisterSession;
use App\Chore\Modules\User\Infra\Memory\UserRepositoryMemory;
use Exception;

class RegisterSessionTest  extends UnitTestCase
{
    private SessionRepositoryMemory $sessionRepo;
    private AttractionRepositoryMemory $attractionRepo;
    private UserRepositoryMemory $userRepo;
    private UniqIdAdapter $uuid;

    private DateTimeAdapter $date;

    /**
     * @throws \Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->date = new DateTimeAdapter();
        $hash = new HashAdapter();

        $this->attractionRepo = new AttractionRepositoryMemory($this->date);
        $this->sessionRepo = new SessionRepositoryMemory();
        $this->userRepo = new UserRepositoryMemory($this->date, $hash);
        $this->placeRepo = new PlaceRepositoryMemory();
        $this->comedianRepo = new ComedianRepositoryMemory();
        $this->uuid = new UniqIdAdapter();
    }

    public function baseSessionData(): array
    {
        return [
            "attractionId" => "63a277fc7b250",
            "userId" => "any_id_1",
            "tickets" => 10,
            "ticketsSold" => 0,
            "ticketsValidated" => 0,
            "startAt" => "20:00:00",
            "finishAt" => "21:00:00",
            "status" => "draft",
        ];
    }

    /**
     * @throws Exception
     */
    public function mockSession($sessionData): Session
    {
        $useCase = new RegisterSession(
            $this->sessionRepo,
            $this->attractionRepo,
            $this->userRepo,
            $this->uuid
        );

        return $useCase->handle($sessionData, $this->date);
    }

    public function baseAttractionData(): array
    {
        return [
            "title" => "any_title",
            "date" => "2023-01-09 00:00:00",
            "status" => "draft",
            "comedianId" => "any_id_1",
            "duration" => '180',
            "placeId" => "any_id",
            "ownerId" => "any_id_3",
        ];
    }

    /**
     * @throws Exception
     */
    public function mockAttraction($attractionData): Attraction
    {
        $useCase = new RegisterAttraction(
            $this->attractionRepo,
            $this->comedianRepo,
            $this->placeRepo,
            $this->userRepo,
            $this->uuid
        );

        return $useCase->handle($attractionData, $this->date);
    }

    public function testMustRegisterSession()
    {
        $date = new DateTimeAdapter();
        $useCase = new RegisterSession(
            $this->sessionRepo,
            $this->attractionRepo,
            $this->userRepo,
            $this->uuid
        );

        $session = $this->baseSessionData();

        $response = $useCase->handle($session, $date);

        $this->assertSame($response->attractionId, $session["attractionId"]);
        $this->assertSame($response->createdBy, $session["userId"]);
    }


    public function testMustRegisterSessionUsingInvalidAttractionId()
    {
        $this->expectExceptionMessage('Attraction not found');

        $date = new DateTimeAdapter();
        $useCase = new RegisterSession(
            $this->sessionRepo,
            $this->attractionRepo,
            $this->userRepo,
            $this->uuid
        );

        $session = $this->baseSessionData();
        $session["attractionId"] = "invalid_attraction_id";

        $response = $useCase->handle($session, $date);

        $this->assertSame($response->attractionId, $session["attractionId"]);
        $this->assertSame($response->createdBy, $session["userId"]);
    }

    public function testMustRegisterSessionUsingInvalidUserId()
    {
        $this->expectExceptionMessage('User not found');

        $date = new DateTimeAdapter();
        $useCase = new RegisterSession(
            $this->sessionRepo,
            $this->attractionRepo,
            $this->userRepo,
            $this->uuid
        );

        $session = $this->baseSessionData();
        $session["userId"] = "invalid_user_id";

        $response = $useCase->handle($session, $date);

        $this->assertSame($response->attractionId, $session["attractionId"]);
        $this->assertSame($response->createdBy, $session["userId"]);
    }

    public function testMustRegisterSessionUsingInvalidTime()
    {
        $this->expectExceptionMessage('Invalid time format');

        $date = new DateTimeAdapter();
        $useCase = new RegisterSession(
            $this->sessionRepo,
            $this->attractionRepo,
            $this->userRepo,
            $this->uuid
        );
        $session = $this->baseSessionData();
        $session["startAt"] = "20:0";

        $response = $useCase->handle($session, $date);

        $this->assertSame($response->attractionId, $session["attractionId"]);
        $this->assertSame($response->createdBy, $session["userId"]);
    }

}
