<?php

namespace App\Http\Controllers;

use App\Chore\Infra\AttractionDAODatabase;
use App\Chore\Infra\AttractionRepositoryDatabase;
use App\Chore\Infra\MySqlAdapter;
use App\Chore\UseCases\ListAttractions;
use App\Models\Attraction;
use Illuminate\Http\Request;

class ListAttractionController extends Controller
{

    public function handle(Request $request)
    {


        $dao = new AttractionRepositoryDatabase();
        $listAttractions = new ListAttractions($dao);
        $output = $listAttractions->handle($request->place);

        return $this->response->successResponse($output);
    }

}