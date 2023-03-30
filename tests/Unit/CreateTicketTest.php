<?php

namespace Tests\Unit;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Adapters\HashAdapter;
use App\Chore\Adapters\RamseyUuidGenerator;
use App\Chore\Infra\Memory\AttractionRepositoryMemory;
use App\Chore\Infra\Memory\UserRepositoryMemory;
use App\Chore\Tickets\Domain\TicketRepository;
use App\Chore\Tickets\Infra\Memory\TicketRepositoryMemory;
use App\Chore\Tickets\UseCases\CreateTicket\CreateTicket;
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
        $this->ticketRepository = new TicketRepositoryMemory();
        $this->uuidGenerator = new RamseyUuidGenerator();

        $bcrypt = new HashAdapter();
        $this->date = new DateTimeAdapter();
        $this->createTicket = new CreateTicket(
            $this->ticketRepository,
            new AttractionRepositoryMemory($this->date),
            new UserRepositoryMemory($this->date, $bcrypt),
            $this->uuidGenerator,
            $this->date
        );
    }

    public function testCreateValidTicket(): void {
        $ownerId = "any_id_1";
        $attractionId = "63a277fc7b250";
        $payedAt = new DateTimeAdapter();
        $status = "paid";

        $this->createTicket->handle($ownerId, $attractionId, $payedAt);

        $ticketId = $this->ticketRepository->getLastInsertedId();
        $ticket = $this->ticketRepository->findById($ticketId);

        $this->assertTrue(Uuid::isValid($ticket->id->toString()));
        $this->assertEquals($ownerId, $ticket->ownerId);
        $this->assertEquals($attractionId, $ticket->attractionId);
        $this->assertEquals($payedAt->format(), $ticket->payedAt->format('Y-m-d H:i:s'));
        $this->assertEquals($status, $ticket->status);
    }

    public function testCreateUsingInvalidUser(): void {

        $this->expectExceptionMessage("User not found");

        $ownerId = "invalid_owner_id";
        $attractionId = "63a277fc7b250";
        $payedAt = new DateTimeAdapter();

        $this->createTicket->handle($ownerId, $attractionId, $payedAt);

    }

    public function testCreateUsingInvalidAttraction(): void {

        $this->expectExceptionMessage("Attraction not found");

        $ownerId = "any_id_1";
        $attractionId = "invalid_attraction_id";
        $payedAt = new DateTimeAdapter();

        $this->createTicket->handle($ownerId, $attractionId, $payedAt);

    }

    public function testMustThrowExceptionPassingFuturePayedDate(): void {

        $this->expectExceptionMessage('Payed date invalid');

        $ownerId = "any_id_1";
        $attractionId = "63a277fc7b250";

        $futureDate = new DateTimeAdapter();
        $futurePayedAt = $futureDate->add(new \DateInterval('P1D'));

        $this->createTicket->handle($ownerId, $attractionId, $futurePayedAt);

    }
}
