<?php

namespace App\Http\Controllers;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Adapters\MySqlAdapter;
use App\Chore\Infra\MySql\ComedianDAODatabase;
use App\Chore\UseCases\GetComedianDetailsById\GetComedianDetailsById;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetComedianByIdController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @OA\Get(
     *   path="/api/v1/comedian/{comedian}",
     *   tags={"comedian"},
     *   operationId="GetComedianByIdController@handle",
     *   description="Returns details by comedian id",
     *   security={ {"token": {} }},
     *   @OA\Parameter(
     *     name="comedian", in="path", example="63a277fc7b251",
     *     description="Comedian id",
     *     @OA\Schema(type="string")
     *   ),
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
        $mysql = new MySqlAdapter();
        $date = new DateTimeAdapter();

        $repo = new ComedianDAODatabase($mysql, $date);
        $useCase = new GetComedianDetailsById($repo);

        $response = $useCase->handle($request->comedian);

        return $this->response->successResponse($response);

    }

}
