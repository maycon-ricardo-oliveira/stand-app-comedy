<?php

namespace App\Http\Controllers;

use App\Chore\Modules\Adapters\DateTimeAdapter\DateTimeAdapter;
use App\Chore\Modules\Attractions\Infra\Memory\AttractionRepositoryMemory;
use App\Chore\Modules\Attractions\Infra\MySql\AttractionDAODatabase;
use App\Chore\Modules\Attractions\UseCases\GetAttractionById\GetAttractionById;
use App\Chore\Modules\Comedians\Infra\MySql\ComedianDAODatabase;
use App\Chore\Modules\Comedians\UseCases\GetComedianDetailsById\GetComedianDetailsById;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetAttractionByIdController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @OA\Get(
     *   path="/api/v1/attraction/{attractionId}",
     *   tags={"comedian"},
     *   operationId="GetAttractionByIdController@handle",
     *   description="Returns attraction details by id",
     *   security={ {"token": {} }},
     *   @OA\Parameter(
     *     name="attractionId", in="path", example="63d332d50ff63",
     *     description="Attraction id",
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
     * @throws Exception
     */
    public function handle(Request $request)
    {

        try {

            $repo = new AttractionDAODatabase($this->dbConnection, $this->time);
            $useCase = new GetAttractionById($repo);
            $response = $useCase->handle($request->attractionId);

            return $this->response->successResponse($response);

        } catch (Exception $exception) {
            return $this->response->badRequestResponse($exception->getMessage());
        }

    }

}
