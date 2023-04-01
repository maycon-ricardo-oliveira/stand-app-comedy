<?php

namespace Tests\Unit;

use App\Chore\Modules\Adapters\DateTimeAdapter\DateTimeAdapter;
use App\Chore\Modules\Adapters\HashAdapter\HashAdapter;
use App\Chore\Modules\Adapters\UuidAdapter\RamseyUuidGenerator;
use App\Chore\Modules\Attractions\Exceptions\AttractionNotFoundException;
use App\Chore\Modules\Attractions\Infra\Memory\AttractionRepositoryMemory;
use App\Chore\Modules\Sessions\Entities\Session;
use App\Chore\Modules\Sessions\Entities\SessionCode;
use App\Chore\Modules\Sessions\Exceptions\MaxTicketsEmittedException;
use App\Chore\Modules\Sessions\Exceptions\SessionNotFoundException;
use App\Chore\Modules\Sessions\Infra\Memory\SessionRepositoryMemory;
use App\Chore\Modules\Tickets\Entities\TicketRepository;
use App\Chore\Modules\Tickets\Infra\Memory\TicketRepositoryMemory;
use App\Chore\Modules\Tickets\UseCases\CreateTicket\CreateTicket;
use App\Chore\Modules\Types\Time\ValidateTime;
use App\Chore\Modules\User\Exceptions\UserNotFoundException;
use App\Chore\Modules\User\Infra\Memory\UserRepositoryMemory;
use DateInterval;
use DateTimeImmutable;
use Exception;
use Ramsey\Uuid\Uuid;

class CreateTicketTest extends UnitTestCase
{
    private TicketRepository $ticketRepository;
    private CreateTicket $createTicket;
    private RamseyUuidGenerator $uuidGenerator;
    private DateTimeAdapter $date;

    /**
     * @throws Exception
     */
    protected function setUp(): void {

        $session = new Session(
            '642660f112d9a',
            "63a277fc7b250",
            SessionCode::fromCode("EAP-230331-0426"),
            10,
            0,
            0,
            ValidateTime::validate("21:00:00"),
            ValidateTime::validate("22:00:00"),
            "published",
            'any_owner',
            new DateTimeImmutable(),
            new DateTimeImmutable(),
        );

        $this->ticketRepository = new TicketRepositoryMemory();
        $this->uuidGenerator = new RamseyUuidGenerator();
        $this->sessionRepo = new SessionRepositoryMemory();

        $this->sessionRepo->register($session);

        $bcrypt = new HashAdapter();
        $this->date = new DateTimeAdapter();
        $this->createTicket = new CreateTicket(
            $this->ticketRepository,
            new AttractionRepositoryMemory($this->date),
            $this->sessionRepo,
            new UserRepositoryMemory($this->date, $bcrypt),
            $this->uuidGenerator,
            $this->date
        );
    }

    /**
     * @throws SessionNotFoundException
     * @throws UserNotFoundException
     * @throws AttractionNotFoundException
     * @throws MaxTicketsEmittedException
     */
    public function testCreateValidTicket(): void
    {
        $ownerId = "any_id_1";
        $attractionId = "63a277fc7b250";
        $sessionId = "642660f112d9a";
        $payedAt = new DateTimeAdapter();
        $status = "paid";

        $this->createTicket->handle($ownerId, $attractionId, $sessionId, $payedAt);

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
     */
    public function testCreateUsingInvalidUser(): void
    {

        $ownerId = "invalid_owner_id";
        $attractionId = "63a277fc7b250";
        $sessionId = "642660f112d9a";
        $payedAt = new DateTimeAdapter();

        $this->expectExceptionMessage("User not found");
        $this->createTicket->handle($ownerId, $attractionId, $sessionId, $payedAt);

    }

    /**
     * @throws UserNotFoundException
     * @throws SessionNotFoundException
     * @throws AttractionNotFoundException
     * @throws MaxTicketsEmittedException
     */
    public function testCreateUsingInvalidAttraction(): void
    {

        $ownerId = "any_id_1";
        $attractionId = "invalid_attraction_id";
        $sessionId = "642660f112d9a";

        $payedAt = new DateTimeAdapter();
        $this->expectExceptionMessage("Attraction not found");
        $this->createTicket->handle($ownerId, $attractionId, $sessionId, $payedAt);

    }

    /**
     * @throws SessionNotFoundException
     * @throws UserNotFoundException
     * @throws AttractionNotFoundException
     * @throws MaxTicketsEmittedException
     */
    public function testMustThrowExceptionUsingInvalidSession(): void
    {

        $ownerId = "any_id_1";
        $attractionId = "63a277fc7b250";
        $sessionId = "invalid_session_id";

        $futureDate = new DateTimeAdapter();
        $futurePayedAt = $futureDate->add(new DateInterval('P1D'));

        $this->expectExceptionMessage('Session not found');
        $this->createTicket->handle($ownerId, $attractionId, $sessionId, $futurePayedAt);

    }

    /**
     * @throws SessionNotFoundException
     * @throws UserNotFoundException
     * @throws AttractionNotFoundException
     * @throws MaxTicketsEmittedException
     */
    public function testMustThrowExceptionPassingFuturePayedDate(): void
    {

        $ownerId = "any_id_1";
        $attractionId = "63a277fc7b250";
        $sessionId = "642660f112d9a";

        $futureDate = new DateTimeAdapter();
        $futurePayedAt = $futureDate->add(new DateInterval('P1D'));

        $this->expectExceptionMessage('Payed date invalid');
        $this->createTicket->handle($ownerId, $attractionId, $sessionId, $futurePayedAt);

    }
}
