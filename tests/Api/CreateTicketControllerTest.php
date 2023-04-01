<?php

namespace Tests\Api;

use App\Chore\Modules\Adapters\DateTimeAdapter\DateTimeAdapter;
use App\Chore\Modules\Adapters\UuidAdapter\RamseyUuidGenerator;
use App\Chore\Modules\Adapters\UuidAdapter\UniqIdAdapter;
use App\Chore\Modules\Attractions\Entities\AttractionRepository;
use App\Chore\Modules\Attractions\Infra\MySql\AttractionDAODatabase;
use App\Chore\Modules\Sessions\Entities\Session;
use App\Chore\Modules\Sessions\Entities\SessionRepository;
use App\Chore\Modules\Sessions\Infra\MySql\SessionDAODatabase;
use App\Chore\Modules\Sessions\UseCases\RegisterSession\RegisterSession;
use App\Chore\Modules\Tickets\Entities\TicketRepository;
use App\Chore\Modules\Tickets\Infra\MySql\TicketDAODatabase;
use App\Chore\Modules\Tickets\UseCases\CreateTicket\CreateTicket;
use App\Chore\Modules\User\Entities\UserRepository;
use App\Chore\Modules\User\Infra\MySql\UserDAODatabase;
use App\Http\Controllers\Tickets\CreateTicketController;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CreateTicketControllerTest extends ApiTestCase
{

    use DatabaseTransactions;
    private TicketRepository $ticketRepo;
    private SessionRepository $sessionRepo;
    private AttractionRepository $attractionRepo;
    private UserRepository $userRepo;
    private CreateTicket $createTicket;
    private RamseyUuidGenerator $uuidGenerator;
    private DateTimeAdapter $date;


    /**
     * @throws \Exception
     */
    public function setUp(): void {
        parent::setUp();
        $this->date = new DateTimeAdapter();
        $this->uuidGenerator = new RamseyUuidGenerator();
        $this->uuid = new UniqIdAdapter();

        $this->ticketRepo = new TicketDAODatabase($this->mysql, $this->date, $this->uuidGenerator);
        $this->sessionRepo = new SessionDAODatabase($this->mysql, $this->date);
        $this->attractionRepo = new AttractionDAODatabase($this->mysql, $this->date);
        $this->userRepo = new UserDAODatabase($this->mysql, $this->date);

        $this->createTicket = new CreateTicket(
            $this->ticketRepo,
            $this->attractionRepo,
            $this->sessionRepo,
            $this->userRepo,
            $this->uuidGenerator,
            $this->date
        );
    }
    public function baseSessionData(): array
    {
        return [
            "id" => '642660f112d9a',
            "attractionId" => "63d332d50ff63",
            "userId" => "any_id_1",
            "tickets" => 10,
            "ticketsSold" => 0,
            "ticketsValidated" => 0,
            "startAt" => "20:00:00",
            "finishAt" => "21:00:00",
            "status" => "published",
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

    public function testMustBeReturn200CreateTicketController()
    {
        $loginResponse = $this->useLogin();

        $ticketId = $this->ticketRepo->getLastInsertedId();
        $this->rollback($ticketId->toString());

        $sessionMockData = $this->baseSessionData();
        $sessionMockData['userId'] = $loginResponse["user"]["id"];
        $session = $this->mockSession($sessionMockData);

        $request = new Request();
        $request->ownerId = $loginResponse["user"]["id"];
        $request->attractionId = $session->attractionId;
        $request->sessionId = $session->id;
        $request->payedAt = $this->date;

        $controller = new CreateTicketController();
        $response = $controller->create($request);

        $this->assertSame(200, $response->getData()->status);
        $this->assertIsObject($response->getData()->data);

    }

    private function rollback($id)
    {
        DB::delete("delete from tickets t where t.id = ?", [$id]);
    }

}
