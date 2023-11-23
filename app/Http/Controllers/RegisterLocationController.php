<?php

namespace App\Http\Controllers;

use App\Chore\Modules\Adapters\UuidAdapter\UniqIdAdapter;
use App\Chore\Modules\User\Entities\Location;
use App\Chore\Modules\User\Entities\UserRepository;
use App\Chore\Modules\User\Infra\Eloquent\UserRepositoryEloquent;
use App\Chore\Modules\User\Infra\MySql\UserDAODatabase;
use App\Chore\Modules\User\UseCases\RegisterLocation\RegisterLocation;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterLocationController extends Controller
{

    private UserRepository $repo;
    private RegisterLocation $useCase;

    public function __construct()
    {
        parent::__construct();
        $uuid = new UniqIdAdapter();
        $this->repo = new UserDAODatabase($this->dbConnection, $this->time);
        $this->useCase = new RegisterLocation($this->repo, $uuid);
    }

    public function handle(Request $request): JsonResponse
    {

        try {

            $location = [
                "userId" => $request->userId,
                "street" => $request->street,
                "neighbourhood" => $request->neighbourhood,
                "city" => $request->city,
                "state" => $request->state,
                "country" => $request->country,
                "zipcode" => $request->zipcode,
                "formattedAddress" => $request->formattedAddress,
                "lat" => $request->lat,
                "lng" => $request->lng,
            ];

            return $this->response->successResponse($this->useCase->handle($location));

        } catch(Exception $exception) {
            return $this->response->badRequestResponse($exception->getMessage());
        }

    }
}