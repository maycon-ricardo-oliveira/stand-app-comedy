<?php

namespace Tests\Unit;

use App\Chore\Modules\Adapters\DateTimeAdapter\DateTimeAdapter;
use App\Chore\Modules\Adapters\HashAdapter\HashAdapter;
use App\Chore\Modules\Adapters\UuidAdapter\RamseyUuidGenerator;
use App\Chore\Modules\Adapters\UuidAdapter\UniqIdAdapter;
use App\Chore\Modules\Attractions\Infra\Memory\AttractionRepositoryMemory;
use App\Chore\Modules\Comedians\Infra\Memory\ComedianRepositoryMemory;
use App\Chore\Modules\Places\Infra\Memory\PlaceRepositoryMemory;
use App\Chore\Modules\Sessions\Entities\Session;
use App\Chore\Modules\Sessions\Infra\Memory\SessionRepositoryMemory;
use App\Chore\Modules\Sessions\UseCases\RegisterSession\RegisterSession;
use App\Chore\Modules\Tickets\Entities\Ticket;
use App\Chore\Modules\Tickets\Entities\TicketRepository;
use App\Chore\Modules\Tickets\Infra\Memory\TicketRepositoryMemory;
use App\Chore\Modules\Tickets\UseCases\CheckinTicket\CheckinTicket;
use App\Chore\Modules\Tickets\UseCases\CreateTicket\CreateTicket;
use App\Chore\Modules\User\Infra\Memory\UserRepositoryMemory;
use Exception;

class CheckinTicketTest extends UnitTestCase
{

    private SessionRepositoryMemory $sessionRepo;
    private AttractionRepositoryMemory $attractionRepo;
    private TicketRepository $ticketRepo;
    private UserRepositoryMemory $userRepo;

    private DateTimeAdapter $date;

    private CreateTicket $createTicketUseCase;
    private CheckinTicket $checkinTicketUseCase;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->date = new DateTimeAdapter();
        $hash = new HashAdapter();

        $this->attractionRepo = new AttractionRepositoryMemory($this->date);
        $this->ticketRepo = new TicketRepositoryMemory();
        $this->sessionRepo = new SessionRepositoryMemory();
        $this->userRepo = new UserRepositoryMemory($this->date, $hash);
        $this->placeRepo = new PlaceRepositoryMemory();
        $this->comedianRepo = new ComedianRepositoryMemory();
        $uuidGenerator = new RamseyUuidGenerator();
        $this->uuid = new UniqIdAdapter();

        $this->createTicketUseCase = new CreateTicket(
            $this->ticketRepo,
            $this->attractionRepo,
            $this->sessionRepo,
            $this->userRepo,
            $uuidGenerator,
            $this->date
        );

        $this->checkinTicketUseCase = new CheckinTicket(
            $this->ticketRepo,
            $this->sessionRepo,
            $this->date,
            $uuidGenerator
        );
    }

    /**
     * @throws Exception
     */
    public function baseTicketData(): array
    {
        $session = $this->mockSession($this->baseSessionData());

        return [
            'ownerId' => 'any_id_1',
            'attractionId' => '63a277fc7b250',
            'sessionId' => $session->id,
            'payedAt' =>  new DateTimeAdapter(),
            'checkinAt' => null,
        ];
    }

    /**
     * @throws Exception
     */
    public function mockTicket($ticketData): ?Ticket
    {
        $ticketId = $this->createTicketUseCase->handle(
            $ticketData['ownerId'],
            $ticketData['attractionId'],
            $ticketData['sessionId'],
            $ticketData['payedAt'],
            $ticketData['checkinAt']
        );
        return $this->ticketRepo->findById($ticketId);
    }

    public function baseSessionData(): array
    {
        return [
            "attractionId" => "63a277fc7b250",
            "userId" => "any_id_1",
            "tickets" => 10,
            "ticketsSold" => 0,
            "ticketsValidated" => 0,
            "startAt" => "20:00:00",
            "finishAt" => "21:00:00",
            "status" => "validating",
        ];
    }

    /**
     * @throws Exception
     */
    public function mockSession($sessionData): Session
    {
        $useCase = new RegisterSession(
            $this->sessionRepo,
            $this->attractionRepo,
            $this->userRepo,
            $this->uuid
        );

        return $useCase->handle($sessionData, $this->date);
    }


    /**
     * @throws Exception
     */
    public function testCheckinValidTicket()
    {
        $status = "used";

        $ticketMockData = $this->baseTicketData();
        $ticket = $this->mockTicket($ticketMockData);

        $result = $this->checkinTicketUseCase->handle($ticket->id->toString());

        $this->assertInstanceOf(Ticket::class, $result);
        $this->assertEquals($result->status->toString(), $status);
        $this->assertNotNull($result->checkinAt);

    }

}
