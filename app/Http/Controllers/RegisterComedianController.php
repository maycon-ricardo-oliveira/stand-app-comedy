<?php

namespace App\Http\Controllers;

use App\Chore\Modules\Adapters\UuidAdapter\UniqIdAdapter;
use App\Chore\Modules\Comedians\Infra\MySql\ComedianDAODatabase;
use App\Chore\Modules\Comedians\UseCases\RegisterComedian\RegisterComedian;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterComedianController extends Controller
{

    private ComedianDAODatabase $comedianRepository;
    private UniqIdAdapter $uuid;
    private RegisterComedian $useCase;

    public function __construct()
    {
        parent::__construct();
        $this->uuid = new UniqIdAdapter();
        $this->comedianRepository = new ComedianDAODatabase($this->dbConnection, $this->time);
        $this->useCase = new RegisterComedian(
            $this->comedianRepository,
            $this->uuid,
        );
    }

    /**
     * @OA\Post(
     *   path="/api/v1/comedians",
     *   tags={"comedian"},
     *   operationId="RegisterComedianController@handle",
     *   description="Register Comedians",
     *   security={ {"token": {} }},
     *   @OA\RequestBody(
     *     required=true,
     *     description="",
     *     @OA\JsonContent(
     *       @OA\Property(property="name", type="string", format="", example="Comediante"),
     *       @OA\Property(property="miniBio", type="string", format="", example="Comediante mini bio"),
     *       @OA\Property(property="thumbnail", type="string", format="", example="https://image.com/image.jpg"),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Successful Operation",
     *     @OA\JsonContent(
     *       type="array",
     *       @OA\Items(ref="#/components/schemas/ComedianResponse"),
     *     ),
     *   ),
     *   @OA\Response(response=404, description="Not found operation"),
     * )
     *
     * @return JsonResponse
     */
    public function handle(Request $request): JsonResponse
    {
        try {
            $comedianData = [
                'name' => $request->name,
                'miniBio' => $request->miniBio,
                'thumbnail' => $request->thumbnail,
                'attractions' => []
            ];
            return $this->response->successResponse($this->useCase->handle($comedianData));
        } catch(Exception $exception) {
            return $this->response->badRequestResponse($exception->getMessage());
        }
    }
}
