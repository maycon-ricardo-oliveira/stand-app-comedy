<?php

namespace App\Http\Controllers;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Adapters\MySqlAdapter;
use App\Chore\Infra\MySql\ComedianDAODatabase;
use App\Chore\UseCases\GetComedianDetailsById\GetComedianDetailsById;
use Illuminate\Http\Request;

class GetComedianByIdController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

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
