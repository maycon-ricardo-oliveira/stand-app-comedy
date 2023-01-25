<?php

namespace App\Http\Controllers;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Adapters\MySqlAdapter;
use App\Chore\Infra\MySql\AttractionDAODatabase;
use App\Chore\UseCases\ListAttractionsByLocation\ListAttractionsByLocation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListAttractionsByLocationController extends Controller
{

    /**
     * @OA\Get(
     *   path="/api/v1/attractions/location",
     *   tags={"attractions"},
     *   operationId="ListAttractionsByLocationController@handle",
     *   description="Returns all attractions available using lat and lng",
     *   security={ {"token": {} }},
     *   @OA\Parameter(
     *     name="lat", in="query", example="-23.546184",
     *     description="Latitude parameter",
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Parameter(
     *     name="lng", in="query", example="-46.5798771",
     *     description="Longitude parameter",
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Parameter(
     *     name="distance", in="query", example="100",
     *     description="Distance parameter",
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Parameter(
     *     name="limit",
     *     description="Limit parameter", in="query", example="100",
     *     @OA\Schema(type="string")
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
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function handle(Request $request): JsonResponse
    {

        $lat = $request->lat;
        $lng = $request->lng;
        $distanceInKM = $request->distance ?? 100;
        $limit = $request->limit ?? 100;

        $dao = new AttractionDAODatabase($this->dbConnection, $this->time);
        $listAttractions = new ListAttractionsByLocation($dao);
        $response = $listAttractions->handle($lat, $lng, $distanceInKM, $limit);

        return $this->response->successResponse($response);
    }
}
