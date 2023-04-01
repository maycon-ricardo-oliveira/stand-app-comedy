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
use App\Chore\Modules\Attractions\Exceptions\CantPossibleUpdateSessionException;
use App\Chore\Modules\Attractions\Infra\Memory\AttractionRepositoryMemory;
use App\Chore\Modules\Attractions\UseCases\RegisterAttraction\RegisterAttraction;
use App\Chore\Modules\Attractions\UseCases\UpdateAttractionStatus\UpdateAttractionStatus;
use App\Chore\Modules\Comedians\Infra\Memory\ComedianRepositoryMemory;
use App\Chore\Modules\Places\Infra\Memory\PlaceRepositoryMemory;
use App\Chore\Modules\Sessions\Entities\Session;
use App\Chore\Modules\Sessions\Infra\Memory\SessionRepositoryMemory;
use App\Chore\Modules\Sessions\UseCases\RegisterSession\RegisterSession;
use App\Chore\Modules\Sessions\UseCases\UpdateSessionStatus\UpdateSessionStatus;
use App\Chore\Modules\User\Infra\Memory\UserRepositoryMemory;
use Exception;

class SessionToAttractionFeatureTest extends FeatureTestCase
{

    private SessionRepositoryMemory $sessionRepo;
    private AttractionRepositoryMemory $attractionRepo;
    private UserRepositoryMemory $userRepo;
    private UniqIdAdapter $uuid;

    private DateTimeAdapter $date;

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

    /**
     * @throws UserNotFoundException
     * @throws InvalidTimeException
     * @throws CantPossibleCreateSessionException
     * @throws AttractionNotFoundException
     * @throws Exception
     */
    public function testMustRegisterSessionOnAFinishAttraction()
    {

        $date = new DateTimeAdapter();
        $useCase = new RegisterSession(
            $this->sessionRepo,
            $this->attractionRepo,
            $this->userRepo,
            $this->uuid
        );

        $sessionData = $this->baseSessionData();
        $attractionData = $this->baseAttractionData();
        $attractionData['status'] = 'finish';
        $attraction = $this->mockAttraction($attractionData);
        $sessionData['attractionId'] = $attraction->id;

        $this->expectException(CantPossibleCreateSessionException::class);
        $useCase->handle($sessionData, $date);
    }

    /**
     * @throws CantPossibleUpdateSessionException
     * @throws AttractionNotFoundException
     * @throws Exception
     */
    public function testCantUpdateSessionStatusOnADraftAttraction()
    {
        $useCase = new UpdateSessionStatus(
            $this->sessionRepo,
            $this->attractionRepo
        );

        $attractionUseCase = new UpdateAttractionStatus(
            $this->attractionRepo,
        );

        $newStatusSession = 'published';
        $newStatusAttraction = 'draft';

        $attractionData = $this->baseAttractionData();
        $attractionData['status'] = 'published';
        $attraction = $this->mockAttraction($attractionData);

        $sessionData = $this->baseSessionData();
        $sessionData['attractionId'] = $attraction->id;
        $session = $this->mockSession($sessionData);

        $attractionUseCase->handle($attraction->id, $newStatusAttraction);

        $this->expectException(CantPossibleUpdateSessionException::class);
        $useCase->handle($session->id, $newStatusSession);
    }

    /**
     * @throws CantPossibleUpdateSessionException
     * @throws AttractionNotFoundException
     * @throws Exception
     */
    public function testCantMustUpdateSessionOnAFinishAttraction()
    {

        $useCase = new UpdateSessionStatus(
            $this->sessionRepo,
            $this->attractionRepo
        );

        $attractionUseCase = new UpdateAttractionStatus(
            $this->attractionRepo,
        );

        $newStatusSession = 'validating';
        $newStatusAttraction = 'finish';

        $attractionData = $this->baseAttractionData();
        $attractionData['status'] = 'published';
        $attraction = $this->mockAttraction($attractionData);

        $sessionData = $this->baseSessionData();
        $sessionData['attractionId'] = $attraction->id;
        $session = $this->mockSession($sessionData);

        $attractionUseCase->handle($attraction->id, $newStatusAttraction);

        $this->expectException(CantPossibleUpdateSessionException::class);
        $useCase->handle($session->id, $newStatusSession);
    }

}
