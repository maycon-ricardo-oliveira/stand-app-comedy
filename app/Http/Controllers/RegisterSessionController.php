<?php

namespace App\Http\Controllers;

use App\Chore\Adapters\MySqlAdapter;
use App\Chore\Adapters\UniqIdAdapter;
use App\Chore\Domain\SessionRepository;
use App\Chore\Domain\UserRepository;
use App\Chore\Infra\MySql\SessionDAODatabase;
use App\Chore\Infra\MySql\UserDAODatabase;
use App\Chore\Modules\Attractions\Entities\AttractionRepository;
use App\Chore\Modules\Attractions\Infra\MySql\AttractionDAODatabase;
use App\Chore\UseCases\RegisterSession\RegisterSession;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterSessionController  extends Controller
{

    private SessionRepository $sessionRepo;
    private AttractionRepository $attractionRepo;
    private UserRepository $userRepo;
    private UniqIdAdapter $uuid;
    private RegisterSession $useCase;

    public function __construct()
    {
        parent::__construct();
        $mysql = new MySqlAdapter();

        $this->attractionRepo = new AttractionDAODatabase($mysql, $this->time);
        $this->sessionRepo = new SessionDAODatabase($mysql, $this->time);
        $this->userRepo = new UserDAODatabase($mysql, $this->time);
        $this->uuid = new UniqIdAdapter();

        $this->useCase = new RegisterSession(
            $this->sessionRepo,
            $this->attractionRepo,
            $this->userRepo,
            $this->uuid
        );

    }

    /**
     * @OA\Post(
     *   path="/api/v1/sessions",
     *   tags={"sessions"},
     *   operationId="RegisterSessionController@handle",
     *   description="Register Session",
     *   security={ {"token": {} }},
     *   @OA\RequestBody(
     *     required=true,
     *     description="",
     *     @OA\JsonContent(
     *       required={"attractionId","userId","tickets","ticketsSold","ticketsValidated","startAt","finishAt","status"},
     *       @OA\Property(property="attractionId", type="string", format="", example="63d332d50ff63"),
     *       @OA\Property(property="userId", type="string", format="", example="63d1c98e22ccb"),
     *       @OA\Property(property="tickets", type="string", format="", example=10),
     *       @OA\Property(property="ticketsSold", type="string", format="", example=0),
     *       @OA\Property(property="ticketsValidated", type="string", format="", example=0),
     *       @OA\Property(property="startAt", type="string", format="", example="21:00:00"),
     *       @OA\Property(property="finishAt", type="string", format="", example="22:00:00"),
     *       @OA\Property(property="status", type="string", format="", example=""),
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Successful Operation",
     *     @OA\JsonContent(
     *       @OA\Schema(ref="#/components/schemas/SessionResponse")
     *     ),
     *   ),
     *   @OA\Response(response=404, description="Not found operation"),
     * )
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function handle(Request $request): JsonResponse
    {

        try {

            $session = [
                "attractionId" => $request->attractionId,
                "userId" => $request->userId,
                "tickets" => $request->tickets,
                "ticketsSold" => $request->ticketsSold,
                "ticketsValidated" => $request->ticketsValidated,
                "startAt" => $request->startAt,
                "finishAt" => $request->finishAt,
                "status" => $request->status,
            ];


            return $this->response->successResponse($this->useCase->handle($session, $this->time));

        } catch(\Exception $exception) {
            return $this->response->badRequestResponse($exception->getMessage());
        }

    }

}
