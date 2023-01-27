<?php

namespace App\Http\Controllers;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Adapters\UniqIdAdapter;
use App\Chore\Infra\MySql\AttractionDAODatabase;
use App\Chore\Infra\MySql\ComedianDAODatabase;
use App\Chore\Infra\MySql\PlaceDAODatabase;
use App\Chore\Infra\MySql\UserDAODatabase;
use App\Chore\UseCases\RegisterAttraction\RegisterAttraction;
use Illuminate\Http\Request;

class RegisterAttractionController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(Request $request)
    {
        $date = new DateTimeAdapter();
        $attractionRepo = new AttractionDAODatabase($this->dbConnection, $date);
        $userRepo = new UserDAODatabase($this->dbConnection, $date);
        $placeRepo = new PlaceDAODatabase($this->dbConnection);
        $comedianRepo = new ComedianDAODatabase($this->dbConnection, $date);
        $uuid = new UniqIdAdapter();

        $useCase = new RegisterAttraction($attractionRepo, $comedianRepo, $placeRepo, $userRepo, $uuid);

        $attraction = [
            "title" => $request->title,
            "date" => $request->date,
            "status" => $request->status,
            "comedianId" => $request->comedianId,
            "placeId" => $request->placeId,
            "ownerId" => $request->ownerId,
            "duration" => $request->duration,
        ];

        return $this->response->successResponse($useCase->handle($attraction, $date));

    }

}
