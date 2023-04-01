<?php

namespace App\Http\Controllers;

use App\Chore\Modules\Adapters\DateTimeAdapter\DateTimeAdapter;
use App\Chore\Modules\Adapters\UuidAdapter\UniqIdAdapter;
use App\Chore\Modules\Attractions\Infra\MySql\AttractionDAODatabase;
use App\Chore\Modules\Attractions\UseCases\RegisterAttraction\RegisterAttraction;
use App\Chore\Modules\Comedians\Infra\MySql\ComedianDAODatabase;
use App\Chore\Modules\Places\Infra\MySql\PlaceDAODatabase;
use App\Chore\Modules\Places\UseCases\RegisterPlace;
use App\Chore\Modules\User\Infra\MySql\UserDAODatabase;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterPlaceController extends Controller
{
    private RegisterPlace $useCase;
    private UniqIdAdapter $uuid;
    private PlaceDAODatabase $placeRepo;

    public function __construct()
    {
        parent::__construct();

        $this->placeRepo = new PlaceDAODatabase($this->dbConnection, $this->time);
        $this->uuid = new UniqIdAdapter();
        $this->useCase = new RegisterPlace($this->placeRepo, $this->time, $this->uuid);
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
    public function handle(Request $request): JsonResponse
    {

        try {

            $placeData = [
                "name" => $request->name,
                "seats" => $request->seats,
                "address" => $request->address,
                "zipcode" => $request->zipcode,
                "image" => $request->image,
                "lat" => $request->lat,
                "lng" => $request->lng,
            ];

            return $this->response->successResponse($this->useCase->handle($placeData));

        } catch(Exception $exception) {
            return $this->response->badRequestResponse($exception->getMessage());
        }
    }

}
