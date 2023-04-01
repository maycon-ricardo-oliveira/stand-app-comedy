<?php

namespace Tests\Unit;

use App\Chore\Exceptions\InvalidTimeException;
use App\Chore\Exceptions\UserNotFoundException;
use App\Chore\Modules\Adapters\DateTimeAdapter\DateTimeAdapter;
use App\Chore\Modules\Adapters\DateTimeAdapter\IDateTime;
use App\Chore\Modules\Adapters\HashAdapter\HashAdapter;
use App\Chore\Modules\Adapters\UuidAdapter\UniqIdAdapter;
use App\Chore\Modules\Attractions\Exceptions\AttractionNotFoundException;
use App\Chore\Modules\Attractions\Exceptions\CantPossibleCreateSessionException;
use App\Chore\Modules\Attractions\Infra\Memory\AttractionRepositoryMemory;
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

    private SessionRepositoryMemory $sessionRepo;
    private AttractionRepositoryMemory $attractionRepo;
    private UserRepositoryMemory $userRepo;
    private UniqIdAdapter $uuid;
    private IDateTime $date;

    private UpdateSessionStatus $useCase;

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
        $this->uuid = new UniqIdAdapter();

        $this->useCase = new UpdateSessionStatus($this->sessionRepo, $this->attractionRepo);
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
            "status" => "finish",
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

    /**
     * @throws Exception
     */
    public function testHandleDraftToPublished()
    {
        $status = 'published';

        $sessionMockData = $this->baseSessionData();
        $sessionMockData['status'] = 'draft';

        $session = $this->mockSession($sessionMockData);

        $result = $this->useCase->handle($session->id, $status);

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

        $sessionMockData = $this->baseSessionData();
        $sessionMockData['status'] = 'published';

        $session = $this->mockSession($sessionMockData);

        $result = $this->useCase->handle($session->id, $status);

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

        $sessionMockData = $this->baseSessionData();
        $sessionMockData['status'] = 'validating';

        $session = $this->mockSession($sessionMockData);

        $result = $this->useCase->handle($session->id, $status);

        $this->assertInstanceOf(Session::class, $result);
        $this->assertEquals($result->status, $status);
    }

    /**
     * @throws InvalidSessionStatusException
     * @throws InvalidSessionStatusTransitionException
     * @throws SessionNotFoundException
     * @throws Exception
     */
    public function testHandleInProgressToFinish()
    {
        $status = 'finish';

        $sessionMockData = $this->baseSessionData();
        $sessionMockData['status'] = 'in_progress';

        $session = $this->mockSession($sessionMockData);

        $result = $this->useCase->handle($session->id, $status);

        $this->assertInstanceOf(Session::class, $result);
        $this->assertEquals($result->status, $status);
    }

    /**
     * @throws Exception
     */
    public function testHandleDraftToValidating()
    {
        $status = 'validating';

        $sessionMockData = $this->baseSessionData();
        $sessionMockData['status'] = 'draft';

        $session = $this->mockSession($sessionMockData);

        $useCase = new UpdateSessionStatus($this->sessionRepo, $this->attractionRepo);
        $this->expectException(InvalidSessionStatusTransitionException::class);
        $useCase->handle($session->id, $status);
    }

    /**
     * @throws InvalidSessionStatusException
     * @throws SessionNotFoundException
     * @throws Exception
     */
    public function testHandleDraftToProgress()
    {
        $status = 'in_progress';

        $sessionMockData = $this->baseSessionData();
        $sessionMockData['status'] = 'draft';

        $session = $this->mockSession($sessionMockData);

        $useCase = new UpdateSessionStatus($this->sessionRepo, $this->attractionRepo);
        $this->expectException(InvalidSessionStatusTransitionException::class);
        $useCase->handle($session->id, $status);
    }

    /**
     * @throws InvalidSessionStatusException
     * @throws SessionNotFoundException
     * @throws Exception
     */
    public function testHandleDraftToFinish()
    {
        $status = 'in_progress';

        $sessionMockData = $this->baseSessionData();
        $sessionMockData['status'] = 'draft';

        $session = $this->mockSession($sessionMockData);

        $this->expectException(InvalidSessionStatusTransitionException::class);
        $this->useCase->handle($session->id, $status);
    }

    /**
     * @throws InvalidSessionStatusException
     * @throws SessionNotFoundException
     * @throws Exception
     */
    public function testHandlePublishedToProgress()
    {
        $status = 'in_progress';

        $sessionMockData = $this->baseSessionData();
        $sessionMockData['status'] = 'published';

        $session = $this->mockSession($sessionMockData);

        $this->expectException(InvalidSessionStatusTransitionException::class);
        $this->useCase->handle($session->id, $status);
    }

    /**
     * @throws InvalidSessionStatusException
     * @throws SessionNotFoundException
     * @throws Exception
     */
    public function testHandlePublishedToFinish()
    {
        $status = 'finish';

        $sessionMockData = $this->baseSessionData();
        $sessionMockData['status'] = 'published';

        $session = $this->mockSession($sessionMockData);

        $this->expectException(InvalidSessionStatusTransitionException::class);
        $this->useCase->handle($session->id, $status);
    }

    /**
     * @throws InvalidSessionStatusException
     * @throws SessionNotFoundException
     * @throws Exception
     */
    public function testHandlePublishedToDraft()
    {
        $status = 'draft';

        $sessionMockData = $this->baseSessionData();
        $sessionMockData['status'] = 'published';

        $session = $this->mockSession($sessionMockData);

        $result = $this->useCase->handle($session->id, $status);
        $this->assertInstanceOf(Session::class, $result);
        $this->assertEquals($result->status, $status);
    }

    /**
     * @throws InvalidSessionStatusException
     * @throws SessionNotFoundException
     * @throws Exception
     */
    public function testHandleValidatingToDraft()
    {
        $status = 'draft';

        $sessionMockData = $this->baseSessionData();
        $sessionMockData['status'] = 'validating';

        $session = $this->mockSession($sessionMockData);

        $this->expectException(InvalidSessionStatusTransitionException::class);
        $this->useCase->handle($session->id, $status);
    }

    /**
     * @throws InvalidSessionStatusException
     * @throws SessionNotFoundException
     * @throws Exception
     */
    public function testHandleValidatingToFinish()
    {
        $status = 'finish';

        $sessionMockData = $this->baseSessionData();
        $sessionMockData['status'] = 'validating';

        $session = $this->mockSession($sessionMockData);

        $this->expectException(InvalidSessionStatusTransitionException::class);
        $this->useCase->handle($session->id, $status);
    }

    /**
     * @throws InvalidSessionStatusException
     * @throws SessionNotFoundException
     * @throws Exception
     */
    public function testHandleValidatingToPublished()
    {
        $status = 'published';

        $sessionMockData = $this->baseSessionData();
        $sessionMockData['status'] = 'validating';

        $session = $this->mockSession($sessionMockData);

        $result = $this->useCase->handle($session->id, $status);
        $this->assertInstanceOf(Session::class, $result);
        $this->assertEquals($result->status, $status);
    }

    /**
     * @throws InvalidSessionStatusException
     * @throws SessionNotFoundException
     * @throws Exception
     */
    public function testHandleProgressToDraft()
    {
        $status = 'draft';

        $sessionMockData = $this->baseSessionData();
        $sessionMockData['status'] = 'in_progress';

        $session = $this->mockSession($sessionMockData);

        $this->expectException(InvalidSessionStatusTransitionException::class);
        $this->useCase->handle($session->id, $status);
    }

    /**
     * @throws InvalidSessionStatusException
     * @throws SessionNotFoundException
     * @throws Exception
     */
    public function testHandleProgressToPublished()
    {
        $status = 'published';

        $sessionMockData = $this->baseSessionData();
        $sessionMockData['status'] = 'in_progress';

        $session = $this->mockSession($sessionMockData);

        $this->expectException(InvalidSessionStatusTransitionException::class);
        $this->useCase->handle($session->id, $status);
    }

    /**
     * @throws InvalidSessionStatusException
     * @throws SessionNotFoundException
     * @throws Exception
     */
    public function testHandleProgressToValidating()
    {
        $status = 'validating';

        $sessionMockData = $this->baseSessionData();
        $sessionMockData['status'] = 'in_progress';

        $session = $this->mockSession($sessionMockData);

        $this->expectException(InvalidSessionStatusTransitionException::class);
        $this->useCase->handle($session->id, $status);
    }

    /**
     * @throws InvalidSessionStatusException
     * @throws SessionNotFoundException
     * @throws Exception
     */
    public function testHandleFinishToDraft()
    {
        $status = 'draft';

        $sessionMockData = $this->baseSessionData();
        $sessionMockData['status'] = 'finish';

        $session = $this->mockSession($sessionMockData);

        $this->expectException(InvalidSessionStatusTransitionException::class);
        $this->useCase->handle($session->id, $status);
    }

    /**
     * @throws InvalidSessionStatusException
     * @throws SessionNotFoundException
     * @throws Exception
     */
    public function testHandleFinishToPublished()
    {
        $status = 'published';

        $sessionMockData = $this->baseSessionData();
        $sessionMockData['status'] = 'finish';

        $session = $this->mockSession($sessionMockData);

        $this->expectException(InvalidSessionStatusTransitionException::class);
        $this->useCase->handle($session->id, $status);
    }

    /**
     * @throws InvalidSessionStatusException
     * @throws SessionNotFoundException
     * @throws Exception
     */
    public function testHandleFinishToValidating()
    {
        $status = 'validating';

        $sessionMockData = $this->baseSessionData();
        $sessionMockData['status'] = 'finish';

        $session = $this->mockSession($sessionMockData);

        $this->expectException(InvalidSessionStatusTransitionException::class);
        $this->useCase->handle($session->id, $status);
    }

    /**
     * @throws InvalidSessionStatusException
     * @throws SessionNotFoundException
     * @throws Exception
     */
    public function testHandleFinishToProgress()
    {
        $status = 'in_progress';

        $sessionMockData = $this->baseSessionData();
        $sessionMockData['status'] = 'finish';

        $session = $this->mockSession($sessionMockData);

        $this->expectException(InvalidSessionStatusTransitionException::class);
        $this->useCase->handle($session->id, $status);
    }

}
