<?php

namespace Tests\Unit;

use App\Chore\Modules\Adapters\DateTimeAdapter\DateTimeAdapter;
use App\Chore\Modules\Adapters\DateTimeAdapter\IDateTime;
use App\Chore\Modules\Adapters\HashAdapter\HashAdapter;
use App\Chore\Modules\Adapters\UuidAdapter\UniqIdAdapter;
use App\Chore\Modules\Attractions\Entities\Attraction;
use App\Chore\Modules\Attractions\Exceptions\InvalidAttractionStatusTransitionException;
use App\Chore\Modules\Attractions\Infra\Memory\AttractionRepositoryMemory;
use App\Chore\Modules\Attractions\UseCases\RegisterAttraction\RegisterAttraction;
use App\Chore\Modules\Attractions\UseCases\UpdateAttractionStatus\UpdateAttractionStatus;
use App\Chore\Modules\Comedians\Infra\Memory\ComedianRepositoryMemory;
use App\Chore\Modules\Places\Infra\Memory\PlaceRepositoryMemory;
use App\Chore\Modules\Session\Exceptions\SessionNotFoundException;
use App\Chore\Modules\Sessions\Entities\Session;
use App\Chore\Modules\Sessions\Exceptions\InvalidSessionStatusException;
use App\Chore\Modules\Sessions\Exceptions\InvalidSessionStatusTransitionException;
use App\Chore\Modules\Sessions\Infra\Memory\SessionRepositoryMemory;
use App\Chore\Modules\Sessions\UseCases\RegisterSession\RegisterSession;
use App\Chore\Modules\Sessions\UseCases\UpdateSessionStatus\UpdateSessionStatus;
use App\Chore\Modules\User\Infra\Memory\UserRepositoryMemory;
use Exception;

class UpdateSessionStatusTest extends UnitTestCase
{

    private PlaceRepositoryMemory $placeRepo;
    private SessionRepositoryMemory $sessionRepo;
    private AttractionRepositoryMemory $attractionRepo;
    private UserRepositoryMemory $userRepo;
    private ComedianRepositoryMemory $comedianRepo;
    private UniqIdAdapter $uuid;
    private IDateTime $date;

    /**
     * @throws Exception
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

    /**
     * @throws Exception
     */
    public function testHandleDraftToPublished()
    {
        $status = 'published';

        $sessionMockData = [
            "attractionId" => "63a277fc7b250",
            "userId" => "any_id_1",
            "tickets" => 10,
            "ticketsSold" => 0,
            "ticketsValidated" => 0,
            "startAt" => "20:00:00",
            "finishAt" => "21:00:00",
            "status" => "draft",
        ];

        $session = $this->mockSession($sessionMockData);

        $useCase = new UpdateSessionStatus($this->sessionRepo);
        $result = $useCase->handle($session->id, $status);

        $this->assertInstanceOf(Session::class, $result);
        $this->assertEquals($result->status, $status);
    }

    /**
     * @throws InvalidSessionStatusException
     * @throws InvalidSessionStatusTransitionException
     * @throws SessionNotFoundException
     * @throws Exception
     */
    public function testHandlePublishedToValidating()
    {
        $status = 'validating';

        $sessionMockData = [
            "attractionId" => "63a277fc7b250",
            "userId" => "any_id_1",
            "tickets" => 10,
            "ticketsSold" => 0,
            "ticketsValidated" => 0,
            "startAt" => "20:00:00",
            "finishAt" => "21:00:00",
            "status" => "published",
        ];

        $session = $this->mockSession($sessionMockData);

        $useCase = new UpdateSessionStatus($this->sessionRepo);
        $result = $useCase->handle($session->id, $status);

        $this->assertInstanceOf(Session::class, $result);
        $this->assertEquals($result->status, $status);
    }

    /**
     * @throws InvalidSessionStatusException
     * @throws InvalidSessionStatusTransitionException
     * @throws SessionNotFoundException
     * @throws Exception
     */
    public function testHandleValidatingToInProgress()
    {
        $status = 'in_progress';

        $sessionMockData = [
            "attractionId" => "63a277fc7b250",
            "userId" => "any_id_1",
            "tickets" => 10,
            "ticketsSold" => 0,
            "ticketsValidated" => 0,
            "startAt" => "20:00:00",
            "finishAt" => "21:00:00",
            "status" => "validating",
        ];

        $session = $this->mockSession($sessionMockData);

        $useCase = new UpdateSessionStatus($this->sessionRepo);
        $result = $useCase->handle($session->id, $status);

        $this->assertInstanceOf(Session::class, $result);
        $this->assertEquals($result->status, $status);
    }

}
