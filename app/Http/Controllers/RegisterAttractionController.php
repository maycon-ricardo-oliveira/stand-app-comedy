<?php

namespace App\Http\Controllers;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Adapters\UniqIdAdapter;
use App\Chore\Infra\MySql\ComedianDAODatabase;
use App\Chore\Infra\MySql\PlaceDAODatabase;
use App\Chore\Infra\MySql\UserDAODatabase;
use App\Chore\Modules\Attractions\Infra\MySql\AttractionDAODatabase;
use App\Chore\Modules\Attractions\UseCases\RegisterAttraction\RegisterAttraction;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterAttractionController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @OA\Post(
     *   path="/api/v1/attractions",
     *   tags={"attractions"},
     *   operationId="RegisterAttractionController@handle",
     *   description="Register Attractions",
     *   security={ {"token": {} }},
     *   @OA\RequestBody(
     *     required=true,
     *     description="",
     *     @OA\JsonContent(
     *       required={"title", "date", "comedianId", "placeId", "ownerId", "duration"},
     *       @OA\Property(property="title", type="string", format="", example="O Problema é meu"),
     *       @OA\Property(property="date", type="string", format="", example="2023-02-21 22:50:59"),
     *       @OA\Property(property="status", type="string", format="", example="draft"),
     *       @OA\Property(property="comedianId", type="string", format="", example="63d1dc4d4b52d"),
     *       @OA\Property(property="placeId", type="string", format="", example="63d332d4be678"),
     *       @OA\Property(property="ownerId", type="string", format="", example="63d1c98e22ccb"),
     *       @OA\Property(property="duration", type="string", format="", example="180"),
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Successful Operation",
     *     @OA\JsonContent(
     *       type="array",
     *       @OA\Items(ref="#/components/schemas/AttractionResponse")
     *     ),
     *   ),
     *   @OA\Response(response=404, description="Not found operation"),
     * )
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function handle(Request $request)
    {
        $date = new DateTimeAdapter();
        $attractionRepo = new AttractionDAODatabase($this->dbConnection, $date);
        $userRepo = new UserDAODatabase($this->dbConnection, $date);
        $placeRepo = new PlaceDAODatabase($this->dbConnection);
        $comedianRepo = new ComedianDAODatabase($this->dbConnection, $date);
        $uuid = new UniqIdAdapter();

        $useCase = new RegisterAttraction($attractionRepo, $comedianRepo, $placeRepo, $userRepo, $uuid);

        $attraction = [
            "title" => $request->title,
            "date" => $request->date,
            "status" => $request->status,
            "comedianId" => $request->comedianId,
            "placeId" => $request->placeId,
            "ownerId" => $request->ownerId,
            "duration" => $request->duration,
        ];

        return $this->response->successResponse($useCase->handle($attraction, $date));

    }

}
