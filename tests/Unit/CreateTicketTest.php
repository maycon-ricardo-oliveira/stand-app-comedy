<?php

namespace Tests\Unit;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Adapters\HashAdapter;
use App\Chore\Adapters\RamseyUuidGenerator;
use App\Chore\Adapters\ValidateTime;
use App\Chore\Domain\Session;
use App\Chore\Domain\SessionCode;
use App\Chore\Infra\Memory\AttractionRepositoryMemory;
use App\Chore\Infra\Memory\SessionRepositoryMemory;
use App\Chore\Infra\Memory\UserRepositoryMemory;
use App\Chore\Modules\Tickets\Domain\TicketRepository;
use App\Chore\Modules\Tickets\Infra\Memory\TicketRepositoryMemory;
use App\Chore\Modules\Tickets\UseCases\CreateTicket\CreateTicket;
use Ramsey\Uuid\Uuid;

class CreateTicketTest extends UnitTestCase
{
    private TicketRepository $ticketRepository;
    private CreateTicket $createTicket;
    private RamseyUuidGenerator $uuidGenerator;
    private DateTimeAdapter $date;

    /**
     * @throws \Exception
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
            "draft",
            'any_owner',
            new \DateTimeImmutable(),
            new \DateTimeImmutable(),
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

    public function testCreateValidTicket(): void {
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

    public function testCreateUsingInvalidUser(): void {

        $this->expectExceptionMessage("User not found");

        $ownerId = "invalid_owner_id";
        $attractionId = "63a277fc7b250";
        $sessionId = "642660f112d9a";
        $payedAt = new DateTimeAdapter();

        $this->createTicket->handle($ownerId, $attractionId, $sessionId, $payedAt);

    }

    public function testCreateUsingInvalidAttraction(): void {

        $this->expectExceptionMessage("Attraction not found");

        $ownerId = "any_id_1";
        $attractionId = "invalid_attraction_id";
        $sessionId = "642660f112d9a";

        $payedAt = new DateTimeAdapter();

        $this->createTicket->handle($ownerId, $attractionId, $sessionId, $payedAt);

    }

    public function testMustThrowExceptionUsingInvalidSession(): void {

        $this->expectExceptionMessage('Session not found');

        $ownerId = "any_id_1";
        $attractionId = "63a277fc7b250";
        $sessionId = "invalid_session_id";

        $futureDate = new DateTimeAdapter();
        $futurePayedAt = $futureDate->add(new \DateInterval('P1D'));

        $this->createTicket->handle($ownerId, $attractionId, $sessionId, $futurePayedAt);

    }

    public function testMustThrowExceptionPassingFuturePayedDate(): void {

        $this->expectExceptionMessage('Payed date invalid');

        $ownerId = "any_id_1";
        $attractionId = "63a277fc7b250";
        $sessionId = "642660f112d9a";

        $futureDate = new DateTimeAdapter();
        $futurePayedAt = $futureDate->add(new \DateInterval('P1D'));

        $this->createTicket->handle($ownerId, $attractionId, $sessionId, $futurePayedAt);

    }
}
