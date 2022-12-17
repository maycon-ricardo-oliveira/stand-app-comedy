<?php

namespace App\Http\Controllers;

use App\Chore\Adapters\MySqlAdapter;
use App\Chore\Infra\MySql\AttractionDAODatabase;
use App\Chore\UseCases\ListAttractionsByLocation\ListAttractionsByLocation;
use Illuminate\Http\Request;

class ListAttractionsByLocationController extends Controller
{

    public function handle(Request $request)
    {

        $lat = $request->lat;
        $lng = $request->lng;
        $distanceInKM = $request->distance ?? 100;
        $limit = $request->limit ?? 100;

        $mysql = new MySqlAdapter();
        $dao = new AttractionDAODatabase($mysql);
        $listAttractions = new ListAttractionsByLocation($dao);
        $response = $listAttractions->handle($lat, $lng, $distanceInKM, $limit);

        return $this->response->successResponse($response);
    }
}
