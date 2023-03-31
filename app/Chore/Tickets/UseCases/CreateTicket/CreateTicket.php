<?php

namespace App\Chore\Tickets\UseCases\CreateTicket;

use App\Chore\Domain\Attraction;
use App\Chore\Domain\AttractionRepository;
use App\Chore\Domain\Session;
use App\Chore\Domain\SessionRepository;
use App\Chore\Domain\User;
use App\Chore\Domain\UserRepository;
use App\Chore\Domain\UuidGenerator;
use App\Chore\Exceptions\AttractionNotFoundException;
use App\Chore\Exceptions\UserNotFoundException;
use App\Chore\Exceptions\SessionNotFoundException;
use App\Chore\Tickets\Domain\TicketId;
use App\Chore\Tickets\Domain\TicketStatus;
use App\Chore\Tickets\Domain\Ticket;
use App\Chore\Tickets\Domain\TicketRepository;
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

        $this->ticketRepository->save($ticket);
        return $this->ticketRepository->getLastInsertedId();
    }

}
