<?php

namespace Tests\Unit;

use App\Chore\Adapters\RamseyUuidGenerator;
use App\Chore\Tickets\Domain\TicketRepository;
use App\Chore\Tickets\Infra\Memory\TicketRepositoryMemory;
use App\Chore\Tickets\UseCases\CreateTicket\CreateTicket;
use Ramsey\Uuid\Uuid;

class CreateTicketTest extends UnitTestCase
{
    private TicketRepository $ticketRepository;
    private CreateTicket $createTicket;
    private RamseyUuidGenerator $uuidGenerator;

    protected function setUp(): void {
        $this->ticketRepository = new TicketRepositoryMemory();
        $this->uuidGenerator = new RamseyUuidGenerator();
        $this->createTicket = new CreateTicket($this->ticketRepository, $this->uuidGenerator);
    }

    public function testCreateValidTicket(): void {
        $ownerId = "1234";
        $attractionId = "5678";
        $payedAt = "2022-01-01 10:00:00";
        $status = "available";
        $checkinAt = "2022-01-01 12:00:00";

        $this->createTicket->execute($ownerId, $attractionId, $payedAt, $checkinAt);

        $ticketId = $this->ticketRepository->getLastInsertedId();
        $ticket = $this->ticketRepository->findById($ticketId);

        $this->assertTrue(Uuid::isValid($ticket->id->toString()));
        $this->assertEquals($ownerId, $ticket->ownerId);
        $this->assertEquals($attractionId, $ticket->attractionId);
        $this->assertEquals($payedAt, $ticket->payedAt);
        $this->assertEquals($status, $ticket->status);
        $this->assertEquals($checkinAt, $ticket->checkinAt);
    }

}
