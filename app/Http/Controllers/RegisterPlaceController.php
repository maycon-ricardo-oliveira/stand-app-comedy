<?php

namespace App\Http\Controllers;

use App\Chore\Modules\Adapters\UuidAdapter\UniqIdAdapter;
use App\Chore\Modules\Places\Infra\MySql\PlaceDAODatabase;
use App\Chore\Modules\Places\UseCases\RegisterPlace;
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
     *   path="/api/v1/places",
     *   tags={"places"},
     *   operationId="RegisterPlaceController@handle",
     *   description="Register Places",
     *   security={ {"token": {} }},
     *   @OA\RequestBody(
     *     required=true,
     *     description="",
     *     @OA\JsonContent(
     *       required={"name","seats","address","zipcode","image","lat","lng"},
     *       @OA\Property(property="name", type="string", format="", example="Hillarius"),
     *       @OA\Property(property="seats", type="string", format="", example="200"),
     *       @OA\Property(property="address", type="string", format="", example="Av. Salim Farah Maluf, 1850 - Quarta Parada, SP"),
     *       @OA\Property(property="zipcode", type="string", format="", example="03157-200"),
     *       @OA\Property(property="image", type="string", format="", example="https://image.com/image.jpg"),
     *       @OA\Property(property="lat", type="string", format="", example="-23.546185"),
     *       @OA\Property(property="lng", type="string", format="", example="-46.579876"),
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Successful Operation",
     *     @OA\JsonContent(
     *       type="array",
     *       @OA\Items(ref="#/components/schemas/PlaceResponse")
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
