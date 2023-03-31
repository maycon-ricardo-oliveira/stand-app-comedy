<?php

namespace Tests\Unit;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Adapters\HashAdapter;
use App\Chore\Adapters\UniqIdAdapter;
use App\Chore\Infra\Memory\ComedianRepositoryMemory;
use App\Chore\Infra\Memory\PlaceRepositoryMemory;
use App\Chore\Infra\Memory\SessionRepositoryMemory;
use App\Chore\Infra\Memory\UserRepositoryMemory;
use App\Chore\Modules\Attractions\Infra\Memory\AttractionRepositoryMemory;
use App\Chore\UseCases\RegisterSession\RegisterSession;

class RegisterSessionTest  extends UnitTestCase
{
    private SessionRepositoryMemory $sessionRepo;
    private AttractionRepositoryMemory $attractionRepo;
    private UserRepositoryMemory $userRepo;
    private UniqIdAdapter $uuid;


    /**
     * @throws \Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $date = new DateTimeAdapter();
        $hash = new HashAdapter();

        $this->attractionRepo = new AttractionRepositoryMemory($date);
        $this->sessionRepo = new SessionRepositoryMemory();
        $this->userRepo = new UserRepositoryMemory($date, $hash);
        $this->placeRepo = new PlaceRepositoryMemory();
        $this->comedianRepo = new ComedianRepositoryMemory();
        $this->uuid = new UniqIdAdapter();
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

        $session = [
            "attractionId" => "63a277fc7b250",
            "userId" => "any_id_1",
            "tickets" => 10,
            "ticketsSold" => 0,
            "ticketsValidated" => 0,
            "startAt" => "20:00:00",
            "finishAt" => "21:00:00",
            "status" => "draft",
        ];

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

        $session = [
            "attractionId" => "invalid_attraction_id",
            "userId" => "any_id_1",
            "tickets" => 10,
            "ticketsSold" => 0,
            "ticketsValidated" => 0,
            "startAt" => "20:00:00",
            "finishAt" => "21:00:00",
            "status" => "draft",
        ];

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

        $session = [
            "attractionId" => "63a277fc7b250",
            "userId" => "invalid_user_id",
            "tickets" => 10,
            "ticketsSold" => 0,
            "ticketsValidated" => 0,
            "startAt" => "20:00:00",
            "finishAt" => "21:00:00",
            "status" => "draft",
        ];

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

        $session = [
            "attractionId" => "63a277fc7b250",
            "userId" => "any_id_1",
            "tickets" => 10,
            "ticketsSold" => 0,
            "ticketsValidated" => 0,
            "startAt" => "20:0",
            "finishAt" => "21:00:00",
            "status" => "draft",
        ];

        $response = $useCase->handle($session, $date);

        $this->assertSame($response->attractionId, $session["attractionId"]);
        $this->assertSame($response->createdBy, $session["userId"]);
    }
}
