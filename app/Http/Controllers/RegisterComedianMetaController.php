<?php

namespace App\Http\Controllers;

use App\Chore\Modules\Adapters\UuidAdapter\UniqIdAdapter;
use App\Chore\Modules\Comedians\Infra\MySql\ComedianDAODatabase;
use App\Chore\Modules\Comedians\UseCases\RegisterComedianMeta\RegisterComedianMeta;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterComedianMetaController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->uuid = new UniqIdAdapter();
        $this->comedianRepository = new ComedianDAODatabase($this->dbConnection, $this->time);
        $this->useCase = new RegisterComedianMeta(
            $this->comedianRepository,
            $this->uuid,
        );
    }

    public function handle(Request $request): JsonResponse
    {
        try {
            $comedianMetaData = [
                'comedianId' => $request->comedianId,
                'name' => $request->name,
                'value' => $request->value,
            ];
            return $this->response->successResponse($this->useCase->handle($comedianMetaData));
        } catch(Exception $exception) {
            return $this->response->badRequestResponse($exception->getMessage());
        }
    }

}
