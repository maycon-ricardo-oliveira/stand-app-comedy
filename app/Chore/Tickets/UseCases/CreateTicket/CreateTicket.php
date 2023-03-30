<?php

namespace App\Chore\Tickets\UseCases\CreateTicket;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Domain\Attraction;
use App\Chore\Domain\AttractionRepository;
use App\Chore\Domain\User;
use App\Chore\Domain\UserRepository;
use App\Chore\Domain\UuidGenerator;
use App\Chore\Exceptions\AttractionNotFoundException;
use App\Chore\Exceptions\InvalidDateException;
use App\Chore\Exceptions\UserNotFoundException;
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

    public function __construct(TicketRepository $ticketRepository, AttractionRepository $attractionRepository, UserRepository $userRepository, UuidGenerator $uuidGenerator, DateTimeImmutable $time )
    {
        $this->ticketRepository = $ticketRepository;
        $this->uuidGenerator = $uuidGenerator;
        $this->attractionRepository = $attractionRepository;
        $this->userRepository = $userRepository;
        $this->time = $time;
    }

    /**
     * @throws UserNotFoundException
     * @throws AttractionNotFoundException
     */
    public function handle(string $ownerId, string $attractionId, DateTimeImmutable $payedAt, DateTimeImmutable|null $checkinAt = null): TicketId
    {

        $owner = $this->userRepository->findUserById($ownerId);
        $attraction = $this->attractionRepository->findAttractionById($attractionId);

        if (!$owner instanceof User) {
            throw new UserNotFoundException();
        }

        if (!$attraction instanceof Attraction) {
            throw new AttractionNotFoundException();
        }

        $ticket = new Ticket($this->time, TicketId::generate($this->uuidGenerator), $owner->id, $attractionId, $payedAt, TicketStatus::paid(), $checkinAt);
        $this->ticketRepository->save($ticket);
        return $this->ticketRepository->getLastInsertedId();
    }

}
