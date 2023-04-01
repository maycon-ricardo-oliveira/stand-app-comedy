<?php

namespace App\Http\Controllers;


use App\Chore\Modules\Places\Infra\MySql\PlaceDAODatabase;
use App\Chore\Modules\Places\UseCases\GetPlace\FindPlaceById;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetPlaceByIdController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @OA\Get(
     *   path="/api/v1/places/{placeId}",
     *   tags={"places"},
     *   operationId="GetPlaceByIdController@handle",
     *   description="Returns place by id",
     *   security={ {"token": {} }},
     *   @OA\Parameter(
     *     name="placeId", in="path", example="63d332d4be676",
     *     description="Place id",
     *     @OA\Schema(type="string")
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
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function handle(Request $request)
    {
        try {

            $repo = new PlaceDAODatabase($this->dbConnection, $this->time);
            $useCase = new FindPlaceById($repo);

            $response = $useCase->handle($request->placeId);

            return $this->response->successResponse($response);

        } catch (Exception $exception) {
            return $this->response->badRequestResponse($exception->getMessage());
        }
    }
}
