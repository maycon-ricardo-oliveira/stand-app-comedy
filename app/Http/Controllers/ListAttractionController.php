<?php

namespace App\Http\Controllers;

use App\Chore\Adapters\EloquentAdapter;
use App\Chore\Infra\Eloquent\AttractionRepositoryDatabase;
use App\Chore\UseCases\ListAttractions\ListAttractions;
use App\Models\Attraction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListAttractionController extends Controller
{
    /**
     * @OA\Get(
     *   path="/api/v1/attractions/{place}",
     *   tags={"attractions"},
     *   operationId="ListAttractionController@handle",
     *   description="Returns all attractions available in a place.",
     *   security={ {"token": {} }},
     *   @OA\Parameter(
     *     name="place",
     *     description="place name",
     *     in="path",
     *     @OA\Schema(
     *       type="string"
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="successful operation",
     *     @OA\JsonContent(
     *       type="array",
     *       @OA\Items(ref="#/components/schemas/Attraction")
     *     ),
     *   ),
     *   @OA\Response(response=404, description="Not found operation"),
     * )
     * @return JsonResponse
     */
    public function handle(Request $request)
    {
        $mysql = new EloquentAdapter(new Attraction());
        $dao = new AttractionRepositoryDatabase($mysql);
        $listAttractions = new ListAttractions($dao);
        $output = $listAttractions->handle($request->place);

        return $this->response->successResponse($output);
    }

}
