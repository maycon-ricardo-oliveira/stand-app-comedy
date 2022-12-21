<?php

namespace App\Http\Controllers;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Adapters\EloquentAdapter;
use App\Chore\Adapters\MySqlAdapter;
use App\Chore\Infra\Eloquent\AttractionRepositoryEloquent;
use App\Chore\Infra\MySql\AttractionDAODatabase;
use App\Chore\UseCases\ListAttractions\ListAttractions;
use App\Models\Attraction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListAttractionsController extends Controller
{
    /**
     * @OA\Get(
     *   path="/api/v1/attractions/{place}",
     *   tags={"attractions"},
     *   operationId="ListAttractionsController@handle",
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
        $mysql = new MySqlAdapter();
        $date = new DateTimeAdapter();
        $dao = new AttractionDAODatabase($mysql, $date);
        $listAttractions = new ListAttractions($dao);
        $output = $listAttractions->handle($request->place);

        return $this->response->successResponse($output);
    }

}
