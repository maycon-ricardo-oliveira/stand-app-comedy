<?php

namespace Tests\Feature;

use App\Chore\Exceptions\InvalidTimeException;
use App\Chore\Exceptions\UserNotFoundException;
use App\Chore\Modules\Adapters\DateTimeAdapter\DateTimeAdapter;
use App\Chore\Modules\Adapters\HashAdapter\HashAdapter;
use App\Chore\Modules\Adapters\UuidAdapter\UniqIdAdapter;
use App\Chore\Modules\Attractions\Entities\Attraction;
use App\Chore\Modules\Attractions\Exceptions\AttractionNotFoundException;
use App\Chore\Modules\Attractions\Exceptions\CantPossibleCreateSessionException;
use App\Chore\Modules\Attractions\Infra\Memory\AttractionRepositoryMemory;
use App\Chore\Modules\Attractions\UseCases\RegisterAttraction\RegisterAttraction;
use App\Chore\Modules\Attractions\UseCases\UpdateAttractionStatus\UpdateAttractionStatus;
use App\Chore\Modules\Comedians\Infra\Memory\ComedianRepositoryMemory;
use App\Chore\Modules\Places\Infra\Memory\PlaceRepositoryMemory;
use App\Chore\Modules\Sessions\Entities\Session;
use App\Chore\Modules\Sessions\Infra\Memory\SessionRepositoryMemory;
use App\Chore\Modules\Sessions\UseCases\RegisterSession\RegisterSession;
use App\Chore\Modules\User\Infra\Memory\UserRepositoryMemory;
use Exception;

class UpdateAttractionAndSessionFeatureTest extends FeatureTestCase
{
    private SessionRepositoryMemory $sessionRepo;
    private AttractionRepositoryMemory $attractionRepo;
    private UserRepositoryMemory $userRepo;
    private UniqIdAdapter $uuid;

    private DateTimeAdapter $date;
    private RegisterAttraction $registerAttractionUseCase;
    private RegisterSession $registerSessionUseCase;
    private UpdateAttractionStatus $updateAttractionUseCase;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {

        $this->date = new DateTimeAdapter();
        $hash = new HashAdapter();

        $this->attractionRepo = new AttractionRepositoryMemory($this->date);
        $this->sessionRepo = new SessionRepositoryMemory();
        $this->userRepo = new UserRepositoryMemory($this->date, $hash);
        $this->placeRepo = new PlaceRepositoryMemory();
        $this->comedianRepo = new ComedianRepositoryMemory();
        $this->uuid = new UniqIdAdapter();

        $this->registerAttractionUseCase = new RegisterAttraction(
            $this->attractionRepo,
            $this->comedianRepo,
            $this->placeRepo,
            $this->userRepo,
            $this->uuid
        );

        $this->updateAttractionUseCase = new UpdateAttractionStatus(
            $this->attractionRepo
        );

        $this->registerSessionUseCase = new RegisterSession(
            $this->sessionRepo,
            $this->attractionRepo,
            $this->userRepo,
            $this->uuid
        );
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
        return $this->registerSessionUseCase->handle($sessionData, $this->date);
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
        return $this->registerAttractionUseCase->handle($attractionData, $this->date);
    }

    /**
     * @throws UserNotFoundException
     * @throws InvalidTimeException
     * @throws CantPossibleCreateSessionException
     * @throws AttractionNotFoundException
     * @throws Exception
     */
    public function testMustUpdateOnlyAttraction()
    {
        // register attraction
        $attractionData = $this->baseAttractionData();
        $attraction = $this->mockAttraction($attractionData);

        $status = "published";

        // register two sessions
        $sessionData = $this->baseSessionData();
        $sessionData['attractionId'] = $attraction->id;
        $sessionOne = $this->registerSessionUseCase->handle($sessionData, $this->date);
        $sessionTwo = $this->registerSessionUseCase->handle($sessionData, $this->date);

        $attraction = $this->updateAttractionUseCase->handle($attraction->id, $status);

        $this->assertSame($attraction->status, $status);
        $this->assertNotSame($sessionOne->status, $status);
        $this->assertNotSame($sessionTwo->status, $status);
    }

}
