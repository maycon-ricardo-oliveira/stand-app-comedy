<?php

namespace App\Http\Controllers;

use App\Chore\Modules\Attractions\UseCases\GetLastAttractions\GetLastAttractions;
use App\Chore\Modules\Attractions\UseCases\ListAttractionsByLocation\ListAttractionsByLocation;
use App\Chore\Modules\Comedians\Infra\MySql\ComedianDAODatabase;
use App\Chore\Modules\Comedians\UseCases\GetAllComedians\GetAllComedians;
use App\Chore\Modules\Places\Infra\MySql\PlaceDAODatabase;
use App\Chore\Modules\Places\UseCases\GetPlace\FindPlaceById;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    const DEFAULT_DISTANCE = 100;

    private GetAllComedians $getAllComedians;
    private ListAttractionsByLocation $attractionsByLocation;
    private GetLastAttractions $getLastAttractions;

    public function __construct(
        ListAttractionsByLocation $attractionsByLocation,
        GetAllComedians $getAllComedians,
        GetLastAttractions $getLastAttractions

    )
    {
        parent::__construct();
        $this->getAllComedians = $getAllComedians;
        $this->attractionsByLocation = $attractionsByLocation;
        $this->getLastAttractions = $getLastAttractions;
    }

    /**
     * @OA\Get(
     *   path="/api/v1/home",
     *   tags={"comedian"},
     *   operationId="HomeController@handle",
     *   description="Returns all home data",
     *   security={ {"token": {} }},
     *   @OA\Response(
     *     response=200,
     *     description="Successful Operation",
     *   ),
     *   @OA\Response(response=404, description="Not found operation"),
     * )
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function handle(Request $request)
    {
        try {

            $limit = $request->limit;

            $allComedians = $this->getAllComedians->handle();

            $nextAttractions = $this->attractionsByLocation->handle($request->lat, $request->lng, self::DEFAULT_DISTANCE);

            $lastAttractions = $this->getLastAttractions->handle($limit);
            // limit 8 items

            $response = [
                "attractionsByLocation" => $nextAttractions,
                "banners" => [],
                "hotComedians" => [],
                "lastComedians" => $allComedians,
                "lastAttractions" => $lastAttractions,
                "user" => [ ]

            ];

            return $this->response->successResponse($response);

        } catch (Exception $exception) {
            return $this->response->badRequestResponse($exception->getMessage());
        }
    }
}
