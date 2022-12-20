<?php

namespace App\Http\Controllers;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Adapters\MySqlAdapter;
use App\Chore\Infra\Memory\AttractionRepositoryMemory;
use App\Chore\Infra\MySql\AttractionDAODatabase;
use App\Chore\UseCases\ListAttractionsByComedian\ListAttractionsByComedian;
use Illuminate\Http\Request;

class ListAttractionsByComedianController extends Controller
{
    public function handle(Request $request)
    {

        $mysql = new MySqlAdapter();
        $date = new DateTimeAdapter();

        $repo = new AttractionDAODatabase($mysql, $date);
        $useCase = new ListAttractionsByComedian($repo);

        $response = $useCase->handle($request->comedian);

        return $this->response->successResponse($response);

    }

}
