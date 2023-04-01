<?php

namespace App\Chore\Modules\Tickets\UseCases\CreateTicket;

use App\Chore\Modules\Adapters\UuidAdapter\UuidGenerator;
use App\Chore\Modules\Attractions\Entities\Attraction;
use App\Chore\Modules\Attractions\Entities\AttractionRepository;
use App\Chore\Modules\Attractions\Exceptions\AttractionNotFoundException;
use App\Chore\Modules\Sessions\Entities\Session;
use App\Chore\Modules\Sessions\Entities\SessionRepository;
use App\Chore\Modules\Sessions\Exceptions\CantEmitTicketsForThisSessionStatusException;
use App\Chore\Modules\Sessions\Exceptions\MaxTicketsEmittedException;
use App\Chore\Modules\Sessions\Exceptions\SessionNotFoundException;
use App\Chore\Modules\Tickets\Entities\Ticket;
use App\Chore\Modules\Tickets\Entities\TicketId;
use App\Chore\Modules\Tickets\Entities\TicketRepository;
use App\Chore\Modules\Tickets\Entities\TicketStatus;
use App\Chore\Modules\User\Entities\User;
use App\Chore\Modules\User\Entities\UserRepository;
use App\Chore\Modules\User\Exceptions\UserNotFoundException;
use DateTimeImmutable;

class CreateTicket
{
    private TicketRepository $ticketRepository;
    private UuidGenerator $uuidGenerator;
    private AttractionRepository $attractionRepository;
    private UserRepository $userRepository;
    private DateTimeImmutable $time;
    private SessionRepository $sessionRepository;

    public function __construct(TicketRepository $ticketRepository, AttractionRepository $attractionRepository, SessionRepository $sessionRepository, UserRepository $userRepository, UuidGenerator $uuidGenerator, DateTimeImmutable $time )
    {
        $this->ticketRepository = $ticketRepository;
        $this->uuidGenerator = $uuidGenerator;
        $this->attractionRepository = $attractionRepository;
        $this->sessionRepository = $sessionRepository;
        $this->userRepository = $userRepository;
        $this->time = $time;
    }

    /**
     * @throws UserNotFoundException
     * @throws AttractionNotFoundException
     * @throws SessionNotFoundException
     * @throws MaxTicketsEmittedException
     * @throws CantEmitTicketsForThisSessionStatusException
     */
    public function handle(string $ownerId, string $attractionId, string $sessionId, DateTimeImmutable $payedAt, DateTimeImmutable|null $checkinAt = null): TicketId
    {

        $owner = $this->userRepository->findUserById($ownerId);
        $attraction = $this->attractionRepository->findAttractionById($attractionId);
        $session = $this->sessionRepository->findSessionById($sessionId);

        if (!$owner instanceof User) {
            throw new UserNotFoundException();
        }

        if (!$attraction instanceof Attraction) {
            throw new AttractionNotFoundException();
        }

        if (!$session instanceof Session) {
            throw new SessionNotFoundException();
        }

        $ticket = new Ticket(
            $this->time,
            TicketId::generate($this->uuidGenerator),
            $owner->id,
            $attraction->id,
            $session->id,
            $payedAt,
            TicketStatus::paid(),
            $checkinAt
        );

        $session->increaseTicketSold();

        $this->ticketRepository->save($ticket);
        $this->sessionRepository->update($session);

        return $this->ticketRepository->getLastInsertedId();
    }

}
