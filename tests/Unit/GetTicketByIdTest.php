<?php

namespace Tests\Unit;

use App\Chore\Adapters\RamseyUuidGenerator;
use App\Chore\Tickets\Domain\Ticket;
use App\Chore\Tickets\Domain\TicketId;
use App\Chore\Tickets\Domain\TicketStatus;
use App\Chore\Tickets\Infra\Memory\TicketRepositoryMemory;
use App\Chore\Tickets\UseCases\GetTicket\GetTicketById;
use DateTimeImmutable;

class GetTicketByIdTest extends UnitTestCase
{

    public function testExecute(): void {
        $ticketId = TicketId::generate(new RamseyUuidGenerator());
        $ownerId = 'user1';
        $attractionId = 'attraction1';
        $payedAt = new DateTimeImmutable();
        $status = TicketStatus::available();
        $checkinAt = null;

        $ticket = new Ticket(
            $ticketId,
            $ownerId,
            $attractionId,
            $payedAt->format('Y-m-d HH:i:s'),
            $status,
            $checkinAt
        );

        $repository = new TicketRepositoryMemory();
        $repository->save($ticket);

        $useCase = new GetTicketById($repository);
        $result = $useCase->handle($ticketId);

        $this->assertEquals($ticket, $result);
    }

    public function testExecuteReturnsNullWhenTicketNotFound(): void {
        $repository = new TicketRepositoryMemory();

        $useCase = new GetTicketById($repository);
        $result = $useCase->handle(TicketId::generate(new RamseyUuidGenerator()));

        $this->assertNull($result);
    }

}
