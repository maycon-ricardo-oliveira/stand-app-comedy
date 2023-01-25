<?php

namespace App\Http\Controllers;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Adapters\MySqlAdapter;
use App\Chore\Infra\MySql\AttractionDAODatabase;
use App\Chore\UseCases\ListAttractionsByComedianId\ListAttractionsByComedianId;
use App\Chore\UseCases\ListAttractionsByComedianName\ListAttractionsByComedianName;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListAttractionsByComedianNameController extends Controller
{
    /**
     * @OA\Get(
     *   path="/api/v1/attractions/comedian/name/{comedianName}",
     *   tags={"attractions"},
     *   operationId="ListAttractionsByComedianNameController@handle",
     *   description="Returns all attractions available by comedian name",
     *   security={ {"token": {} }},
     *   @OA\Parameter(
     *     name="comedianName", in="path", example="Afonso",
     *     description="Comedian name",
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


        $repo = new AttractionDAODatabase($this->dbConnection, $this->time);
        $useCase = new ListAttractionsByComedianName($repo);

        $response = $useCase->handle($request->comedianName);

        return $this->response->successResponse($response);

    }

}
