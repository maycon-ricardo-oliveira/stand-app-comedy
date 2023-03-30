<?php

namespace App\Chore\Tickets\Infra\MySql;


use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Domain\IDateTime;
use App\Chore\Domain\UuidGenerator;
use App\Chore\Infra\MySql\DBConnection;
use App\Chore\Tickets\Domain\Ticket;
use App\Chore\Tickets\Domain\TicketId;
use App\Chore\Tickets\Domain\TicketRepository;

class TicketDAODatabase implements TicketRepository
{

    private DBConnection $connection;

    public IDateTime $time;

    public function __construct(DBConnection $connection, IDateTime $time, UuidGenerator $uuidGenerator)
    {
        $this->connection = $connection;
        $this->time = $time;

        $this->uuidGenerator = $uuidGenerator;
    }
    public function save(Ticket $ticket): bool
    {
        $query = "INSERT INTO tickets (
                     id,
                     owner_id,
                     attraction_id,
                     payed_at,
                     checkin_at,
                     status,
                     created_at,
                     updated_at)
                  VALUES (:id, :owner_id, :attraction_id, :payed_at, :checkin_at, :status, :created_at,  :updated_at)";

        $params = [
            "id" => $ticket->id->toString(),
            "owner_id" => $ticket->ownerId,
            "attraction_id" => $ticket->attractionId,
            "payed_at" => $ticket->payedAt->format('Y-m-d H:i:s'),
            "checkin_at" => $ticket->payedAt?->format('Y-m-d H:i:s'),
            "status" => $ticket->status,
            "created_at" => $this->time->format('Y-m-d H:i:s'),
            "updated_at" => $this->time->format('Y-m-d H:i:s'),
        ];

        $this->connection->query($query, $params);
        return true;
    }

    public function findById(TicketId $id): ?Ticket
    {
        $query = "select * from tickets t
         where t.id = :id";
        $params = ['id' => $id->toString()];

        $data = $this->connection->query($query, $params);

        return new Ticket(
            $this->time,
            $data[0]->id,
            $data[0]->owner_id,
            $data[0]->attraction_id,
            new DateTimeAdapter($data[0]->payed_at),
            $data[0]->status,
            $data[0]->checkin_at ? new DateTimeAdapter($data[0]->checkin_at) : null,
        );
    }

    public function getLastInsertedId(): ?TicketId
    {
        $query = "select id from tickets t
         order by created_at desc limit 1";

        $data = $this->connection->query($query);

        return TicketId::fromString($data[0]['id'], $this->uuidGenerator);
    }
}
