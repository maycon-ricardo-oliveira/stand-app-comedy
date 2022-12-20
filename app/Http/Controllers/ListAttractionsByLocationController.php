<?php

namespace App\Http\Controllers;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Adapters\MySqlAdapter;
use App\Chore\Infra\Memory\AttractionRepositoryMemory;
use App\Chore\Infra\MySql\AttractionDAODatabase;
use App\Chore\UseCases\ListAttractionsByLocation\ListAttractionsByLocation;
use Illuminate\Http\Request;

class ListAttractionsByLocationController extends Controller
{

    /**
     * @OA\Schema(
     *   schema="AttractionWithLocation",
     *   description="Attraction",
     *   title="Attraction Schema",
     *   @OA\Property(property="id", type="string", description="The attraction id"),
     *   @OA\Property(property="artist", type="string", description="The attraction artist"),
     *   @OA\Property(property="place", type="string", description="The attraction place"),
     *   @OA\Property(property="date", type="string", description="The attraction date"),
     *   @OA\Property(property="title", type="string", description="The attraction title"),
     * )
     */
    /**
     * @OA\Schema(
     *   schema="PlaceResponse",
     *   description="Attraction",
     *   title="Place Schema",
     *   @OA\Property(property="id", type="string", description="The place id"),
     *   @OA\Property(property="name", type="string", description="The place name"),
     *   @OA\Property(property="address", type="string", description="The place address"),
     *   @OA\Property(property="zipcode", type="string", description="The place zipcode"),
     *   @OA\Property(property="lat", type="string", description="The place lat"),
     *   @OA\Property(property="lng", type="string", description="The place lng"),
     *   @OA\Property(property="distance", type="string", description="The place distance"),
     * )
     */
    public function handle(Request $request)
    {

        $lat = $request->lat;
        $lng = $request->lng;
        $distanceInKM = $request->distance ?? 100;
        $limit = $request->limit ?? 100;

        $date = new DateTimeAdapter();
        $mysql = new MySqlAdapter();

        $dao = new AttractionDAODatabase($mysql, $date);
        $listAttractions = new ListAttractionsByLocation($dao);
        $response = $listAttractions->handle($lat, $lng, $distanceInKM, $limit);

        return $this->response->successResponse($response);
    }
}
