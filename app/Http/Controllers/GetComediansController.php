<?php

namespace App\Http\Controllers;

use App\Chore\Modules\Comedians\Infra\MySql\ComedianDAODatabase;
use App\Chore\Modules\Comedians\UseCases\GetAllComedians\GetAllComedians;
use App\Chore\Modules\Places\Infra\MySql\PlaceDAODatabase;
use App\Chore\Modules\Places\UseCases\GetPlace\FindPlaceById;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetComediansController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @OA\Get(
     *   path="/api/v1/comedians",
     *   tags={"comedian"},
     *   operationId="GetComediansController@handle",
     *   description="Returns all comedians",
     *   security={ {"token": {} }},
     *   @OA\Response(
     *     response=200,
     *     description="Successful Operation",
     *     @OA\JsonContent(
     *       type="array",
     *       @OA\Items(ref="#/components/schemas/ComedianResponse")
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
        try {

            $repo = new ComedianDAODatabase($this->dbConnection, $this->time);
            $useCase = new GetAllComedians($repo);

            $response = $useCase->handle();

            return $this->response->successResponse($response);

        } catch (Exception $exception) {
            return $this->response->badRequestResponse($exception->getMessage());
        }
    }
}
