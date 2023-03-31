<?php

namespace App\Http\Controllers;


use App\Chore\Modules\Attractions\Infra\MySql\AttractionDAODatabase;
use App\Chore\Modules\Attractions\UseCases\ListAttractionsByPlace\ListAttractionsByPlace;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListAttractionsByPlaceController extends Controller
{
    /**
     * @OA\Get(
     *   path="/api/v1/attractions/{place}",
     *   tags={"attractions"},
     *   operationId="ListAttractionsByPlaceController@handle",
     *   description="Returns all attractions available in a place.",
     *   security={ {"token": {} }},
     *   @OA\Parameter(
     *     name="place", in="path",
     *     description="place name",
     *     @OA\Schema(type="string"),
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
     * @return JsonResponse
     */
    public function handle(Request $request)
    {
        $dao = new AttractionDAODatabase($this->dbConnection, $this->time);
        $listAttractions = new ListAttractionsByPlace($dao);
        $output = $listAttractions->handle($request->place);

        return $this->response->successResponse($output);
    }

}
