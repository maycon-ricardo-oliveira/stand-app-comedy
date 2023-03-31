<?php

namespace App\Chore\Modules\Sessions\Infra\MySql;

use App\Chore\Modules\Adapters\DateTimeAdapter\DateTimeAdapter;
use App\Chore\Modules\Adapters\DateTimeAdapter\IDateTime;
use App\Chore\Modules\Adapters\MySqlAdapter\BaseDAODatabase;
use App\Chore\Modules\Adapters\MySqlAdapter\DBConnection;
use App\Chore\Modules\Sessions\Entities\Session;
use App\Chore\Modules\Sessions\Entities\SessionCode;
use App\Chore\Modules\Sessions\Entities\SessionRepository;
use App\Chore\Modules\Types\Time\Time;

class SessionDAODatabase extends BaseDAODatabase implements SessionRepository
{

    private DBConnection $connection;

    public IDateTime $time;

    public function __construct(DBConnection $connection, IDateTime $time)
    {
        parent::__construct();
        $this->connection = $connection;
        $this->time = $time;

    }

    /**
     * @throws \Exception
     */
    private function mapper($data): Session {
        return new Session(
            $data["id"],
            $data["attraction_id"],
            SessionCode::fromCode($data["session_code"]),
            $data["tickets"],
            $data["tickets_sold"],
            $data["tickets_validated"],
            new Time($data["start_at"]),
            new Time($data["finish_at"]),
            $data["status"],
            $data["created_by"],
            new DateTimeAdapter($data["created_at"]),
            new DateTimeAdapter($data["updated_at"]),
        );
    }
    public function getLastInsertedId(): ?string
    {
        $query = "select id from sessions
         order by created_at desc limit 1";

        $data = $this->connection->query($query);

        return count($data) == 0 ? null : $data[0]['id'];
    }

    /**
     * @throws \Exception
     */
    public function findSessionById(string $sessionId): ?Session
    {
        $query = "select * from sessions s
         where s.id = :id";
        $params = ['id' => $sessionId];

        $data = $this->connection->query($query, $params);

        if (count($data) == 0) return null;
        return $this->mapper($data[0]);
    }

    public function getSessionsByAttractionsId(string $attractionId)
    {
        $query = "select * from sessions s
         where s.id = :id";
        $params = ['attraction_id' => $attractionId];

        $data = $this->connection->query($query, $params);
        if (count($data) == 0) return null;
        return $this->mapper($data[0]);
    }

    public function register(Session $session): bool
    {
        $query = "INSERT INTO sessions (
                    id,
                    attraction_id,
                    session_code,
                    tickets,
                    tickets_sold,
                    tickets_validated,
                    start_at,
                    finish_at,
                    status,
                    created_at,
                    updated_at,
                    created_by)
                  VALUES (:id, :attraction_id, :session_code, :tickets, :tickets_sold, :tickets_validated, :start_at, :finish_at, :status, :created_at, :updated_at, :created_by)";


        $params = [
            "id" => $session->id,
            "attraction_id" => $session->attractionId,
            "session_code" => $session->sessionCode->toString(),
            "tickets" => $session->tickets,
            "tickets_sold" => $session->ticketsSold,
            "tickets_validated" => $session->ticketsValidated,
            "start_at" => $session->startAt->getTime(),
            "finish_at" => $session->finishAt->getTime(),
            "status" => $session->status,
            "created_at" => $session->createdAt->format('Y-m-d H:i:s'),
            "updated_at" => $session->updatedAt->format('Y-m-d H:i:s'),
            "created_by" => $session->createdBy
        ];

        $this->connection->query($query, $params);
        return true;
    }
}
