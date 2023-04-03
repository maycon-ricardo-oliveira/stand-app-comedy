<?php

namespace Tests\Feature;

use App\Chore\Exceptions\InvalidTimeException;
use App\Chore\Modules\Adapters\DateTimeAdapter\DateTimeAdapter;
use App\Chore\Modules\Adapters\HashAdapter\HashAdapter;
use App\Chore\Modules\Adapters\UuidAdapter\RamseyUuidGenerator;
use App\Chore\Modules\Adapters\UuidAdapter\UniqIdAdapter;
use App\Chore\Modules\Attractions\Exceptions\AttractionNotFoundException;
use App\Chore\Modules\Attractions\Infra\Memory\AttractionRepositoryMemory;
use App\Chore\Modules\Sessions\Entities\Session;
use App\Chore\Modules\Sessions\Entities\SessionRepository;
use App\Chore\Modules\Sessions\Exceptions\CantEmitTicketsForThisSessionStatusException;
use App\Chore\Modules\Sessions\Exceptions\MaxTicketsEmittedException;
use App\Chore\Modules\Sessions\Exceptions\SessionNotFoundException;
use App\Chore\Modules\Sessions\Infra\Memory\SessionRepositoryMemory;
use App\Chore\Modules\Sessions\UseCases\RegisterSession\RegisterSession;
use App\Chore\Modules\Sessions\UseCases\UpdateSessionStatus\UpdateSessionStatus;
use App\Chore\Modules\Tickets\Entities\TicketRepository;
use App\Chore\Modules\Tickets\Infra\Memory\TicketRepositoryMemory;
use App\Chore\Modules\Tickets\UseCases\CheckinTicket\CheckinTicket;
use App\Chore\Modules\Tickets\UseCases\CreateTicket\CreateTicket;
use App\Chore\Modules\User\Exceptions\UserNotFoundException;
use App\Chore\Modules\User\Infra\Memory\UserRepositoryMemory;
use Exception;
use Ramsey\Uuid\Uuid;


class CreateAValidTicketFeatureTest extends FeatureTestCase
{

    private TicketRepository $ticketRepository;

    private SessionRepository $sessionRepo;
    private CreateTicket $createTicket;
    private CheckinTicket $checkinTicket;
    private RamseyUuidGenerator $uuidGenerator;
    private DateTimeAdapter $date;
    private UpdateSessionStatus $updateSessionUseCase;

    /**
     * @throws Exception|InvalidTimeException
     */
    public function setUp(): void
    {
        $hash = new HashAdapter();
        $this->date = new DateTimeAdapter();
        $this->ticketRepository = new TicketRepositoryMemory();
        $this->uuidGenerator = new RamseyUuidGenerator();
        $this->sessionRepo = new SessionRepositoryMemory();
        $this->attractionRepo = new AttractionRepositoryMemory($this->date);
        $this->userRepo = new UserRepositoryMemory($this->date, $hash);
        $this->uuid = new UniqIdAdapter();

        $this->createTicket = new CreateTicket(
            $this->ticketRepository,
            new AttractionRepositoryMemory($this->date),
            $this->sessionRepo,
            new UserRepositoryMemory($this->date, $hash),
            $this->uuidGenerator,
            $this->date
        );

        $this->checkinTicket = new CheckinTicket(
            $this->ticketRepository,
            $this->sessionRepo,
            $this->date,
            $this->uuidGenerator
        );

        $this->updateSessionUseCase = new UpdateSessionStatus(
            $this->sessionRepo,
            $this->attractionRepo
        );
    }

    public function baseSessionData(): array
    {
        return [
            "id" => '642660f112d9a',
            "attractionId" => "63a277fc7b250",
            "userId" => "any_id_1",
            "tickets" => 10,
            "ticketsSold" => 0,
            "ticketsValidated" => 0,
            "startAt" => "20:00:00",
            "finishAt" => "21:00:00",
            "status" => "published",
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
     * @throws SessionNotFoundException
     * @throws UserNotFoundException
     * @throws MaxTicketsEmittedException
     * @throws AttractionNotFoundException
     * @throws Exception
     */
    public function testCreateValidTicket(): void
    {
        $ownerId = "any_id_1";
        $attractionId = "63a277fc7b250";
        $payedAt = new DateTimeAdapter();
        $status = "paid";

        $sessionMockData = $this->baseSessionData();
        $session = $this->mockSession($sessionMockData);

        $this->createTicket->handle($ownerId, $attractionId, $session->id, $payedAt);

        $ticketId = $this->ticketRepository->getLastInsertedId();
        $ticket = $this->ticketRepository->findById($ticketId);

        $this->assertTrue(Uuid::isValid($ticket->id->toString()));
        $this->assertEquals($ownerId, $ticket->ownerId);
        $this->assertEquals($attractionId, $ticket->attractionId);
        $this->assertEquals($payedAt->format(), $ticket->payedAt->format('Y-m-d H:i:s'));
        $this->assertEquals($status, $ticket->status->toString());
    }

    /**
     * @throws SessionNotFoundException
     * @throws UserNotFoundException
     * @throws AttractionNotFoundException
     * @throws MaxTicketsEmittedException
     * @throws Exception
     */
    public function testMustIncreaseTicketsSoldWhenCreateValidTicket(): void
    {
        $ownerId = "any_id_1";
        $attractionId = "63a277fc7b250";
        $payedAt = new DateTimeAdapter();

        $sessionMockData = $this->baseSessionData();
        $session = $this->mockSession($sessionMockData);

        $oldTicketsSold = $session->ticketsSold;

        $this->createTicket->handle($ownerId, $attractionId, $session->id, $payedAt);

        $ticketId = $this->ticketRepository->getLastInsertedId();
        $ticket = $this->ticketRepository->findById($ticketId);

        $afterCreateTicketSession = $this->sessionRepo->findSessionById($ticket->sessionId);

        $this->assertTrue(Uuid::isValid($ticket->id->toString()));
        $this->assertEquals($ownerId, $ticket->ownerId);
        $this->assertEquals($attractionId, $ticket->attractionId);

        $this->assertEquals($oldTicketsSold + 1, $afterCreateTicketSession->ticketsSold);
        $this->assertEquals($session->id, $afterCreateTicketSession->id);
    }

    /**
     * @throws SessionNotFoundException
     * @throws UserNotFoundException
     * @throws AttractionNotFoundException
     * @throws MaxTicketsEmittedException
     * @throws Exception
     */
    public function testMustIncreaseTicketsValidatedWhenCheckinValidTicket(): void
    {
        $ownerId = "any_id_1";
        $attractionId = "63a277fc7b250";
        $payedAt = new DateTimeAdapter();

        $sessionMockData = $this->baseSessionData();
        $session = $this->mockSession($sessionMockData);

        $ticketsValidated = $session->ticketsValidated;
        $this->createTicket->handle($ownerId, $attractionId, $session->id, $payedAt);

        $ticketId = $this->ticketRepository->getLastInsertedId();
        $ticket = $this->ticketRepository->findById($ticketId);

        $this->updateSessionUseCase->handle($session->id, 'validating');
        $checkin = $this->checkinTicket->handle($ticketId->toString());
        $afterCheckinTicketSession = $this->sessionRepo->findSessionById($session->id);

        $this->assertTrue(Uuid::isValid($ticket->id->toString()));
        $this->assertEquals($ownerId, $ticket->ownerId);
        $this->assertEquals($attractionId, $ticket->attractionId);
        $this->assertEquals($ticketsValidated + 1, $afterCheckinTicketSession->ticketsValidated);
        $this->assertEquals($session->id, $afterCheckinTicketSession->id);
        $this->assertEquals($checkin->checkinAt, $this->date);
    }

    /**
     * @throws SessionNotFoundException
     * @throws UserNotFoundException
     * @throws AttractionNotFoundException
     * @throws MaxTicketsEmittedException
     * @throws Exception
     */
    public function testMustThrowMaxTicketsEmittedException(): void
    {
        $ownerId = "any_id_1";
        $attractionId = "63a277fc7b250";
        $payedAt = new DateTimeAdapter();

        $sessionMockData = $this->baseSessionData();
        $sessionMockData['ticketsSold'] = 10;
        $session = $this->mockSession($sessionMockData);

        $this->expectException(MaxTicketsEmittedException::class);
        $this->createTicket->handle($ownerId, $attractionId, $session->id, $payedAt);
    }

    /**
     * @throws SessionNotFoundException
     * @throws UserNotFoundException
     * @throws AttractionNotFoundException
     * @throws MaxTicketsEmittedException
     * @throws Exception
     */
    public function testMustThrowCantEmitTicketsForThisSessionStatusException(): void
    {
        $ownerId = "any_id_1";
        $attractionId = "63a277fc7b250";
        $payedAt = new DateTimeAdapter();

        $sessionMockData = $this->baseSessionData();
        $sessionMockData['status'] = 10;
        $session = $this->mockSession($sessionMockData);

        $this->expectException(CantEmitTicketsForThisSessionStatusException::class);
        $this->createTicket->handle($ownerId, $attractionId, $session->id, $payedAt);
    }

    /**
     * @throws SessionNotFoundException
     * @throws UserNotFoundException
     * @throws AttractionNotFoundException
     * @throws MaxTicketsEmittedException
     * @throws Exception
     */
    public function testTicketsSoldOutToSession(): void
    {
        $ownerId = "any_id_1";
        $attractionId = "63a277fc7b250";
        $payedAt = new DateTimeAdapter();

        $sessionMockData = $this->baseSessionData();
        $session = $this->mockSession($sessionMockData);
        $oldTicketsSold = $session->ticketsSold;

        $this->createTicket->handle($ownerId, $attractionId, $session->id, $payedAt);

        $ticketId = $this->ticketRepository->getLastInsertedId();
        $ticket = $this->ticketRepository->findById($ticketId);

        $afterCreateTicketSession = $this->sessionRepo->findSessionById($ticket->sessionId);

        $this->assertTrue(Uuid::isValid($ticket->id->toString()));
        $this->assertEquals($ownerId, $ticket->ownerId);
        $this->assertEquals($attractionId, $ticket->attractionId);

        $this->assertEquals($oldTicketsSold + 1, $afterCreateTicketSession->ticketsSold);
        $this->assertEquals($session->id, $afterCreateTicketSession->id);
    }

}
