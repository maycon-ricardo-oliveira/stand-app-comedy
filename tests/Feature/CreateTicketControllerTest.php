<?php

namespace Tests\Feature;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Adapters\RamseyUuidGenerator;
use App\Chore\Infra\MySql\AttractionDAODatabase;
use App\Chore\Infra\MySql\SessionDAODatabase;
use App\Chore\Modules\Tickets\Domain\TicketRepository;
use App\Chore\Modules\Tickets\Infra\MySql\TicketDAODatabase;
use App\Chore\Modules\Tickets\UseCases\CreateTicket\CreateTicket;
use App\Http\Controllers\Tickets\CreateTicketController;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CreateTicketControllerTest extends FeatureTestCase
{

    use DatabaseTransactions;
    private TicketRepository $ticketRepository;
    private CreateTicket $createTicket;
    private RamseyUuidGenerator $uuidGenerator;
    private DateTimeAdapter $date;

    /**
     * @throws \Exception
     */
    public function setUp(): void {
        parent::setUp();
        $this->date = new DateTimeAdapter();
        $uuidGenerator = new RamseyUuidGenerator();

        $this->ticketRepository = new TicketDAODatabase($this->mysql, $this->date, $uuidGenerator);
        $this->uuidGenerator = new RamseyUuidGenerator();

        $this->createTicket = new CreateTicket(
            $this->ticketRepository,
            new AttractionDAODatabase($this->mysql, $this->date),
            new SessionDAODatabase($this->mysql, $this->date),
            $this->repo,
            $this->uuidGenerator,
            $this->date
        );
    }

    public function testMustBeReturn200CreateTicketController()
    {
        $loginResponse = $this->useLogin();

        $ticketId = $this->ticketRepository->getLastInsertedId();
        $this->rollback($ticketId->toString());

        $request = new Request();
        $request->ownerId = $loginResponse["user"]["id"];
        $request->attractionId = '63d332d50ff63';
        $request->sessionId = '642660f112d9a';
        $request->payedAt =new DateTimeAdapter();

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
