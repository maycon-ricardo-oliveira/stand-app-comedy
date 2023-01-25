<?php

namespace App\Http\Controllers;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Adapters\MySqlAdapter;
use App\Chore\Infra\MySql\AttractionDAODatabase;
use App\Chore\UseCases\ListAttractionsByComedianId\ListAttractionsByComedianId;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListAttractionsByComedianController extends Controller
{
    /**
     * @OA\Get(
     *   path="/api/v1/attractions/comedian/{comedianId}",
     *   tags={"attractions"},
     *   operationId="ListAttractionsByComedianController@handle",
     *   description="Returns all attractions available by comedian id",
     *   security={ {"token": {} }},
     *   @OA\Parameter(
     *     name="comedianId", in="path", example="63a277fc7b251",
     *     description="Comedian id",
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
    public function handle(Request $request)
    {
        $this->validate($request, [
            'comedianId' => 'required|string'
        ]);

        $repo = new AttractionDAODatabase($this->dbConnection, $this->time);
        $useCase = new ListAttractionsByComedianId($repo);

        $response = $useCase->handle($request->comedianId);

        return $this->response->successResponse($response);

    }

}
