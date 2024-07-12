<?php

namespace App\Http\Controllers;

use App\Chore\Modules\Adapters\AuthAdapter\AuthAdapter;
use App\Chore\Modules\Attractions\Infra\MySql\AttractionDAODatabase;
use App\Chore\Modules\Attractions\UseCases\GetLastAttractions\GetLastAttractions;
use App\Chore\Modules\Attractions\UseCases\ListAttractionsByLocation\ListAttractionsByLocation;
use App\Chore\Modules\Banners\Infra\BannersRepository;
use App\Chore\Modules\Banners\UseCases\GetBannersByScreen;
use App\Chore\Modules\Comedians\Infra\MySql\ComedianDAODatabase;
use App\Chore\Modules\Comedians\UseCases\GetAllComedians\GetAllComedians;
use App\Chore\Modules\Places\Infra\MySql\PlaceDAODatabase;
use App\Chore\Modules\Places\UseCases\GetPlace\FindPlaceById;
use App\Chore\Modules\User\Infra\MySql\UserDAODatabase;
use App\Chore\Modules\User\UseCases\GetUserProfile\GetUserProfileById;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    const DEFAULT_DISTANCE = 100;

    private GetAllComedians $getAllComedians;
    private ListAttractionsByLocation $attractionsByLocation;
    private GetLastAttractions $getLastAttractions;
    private GetBannersByScreen $getBanners;

    const HOME = 'home';
    private AuthAdapter $auth;
    private GetUserProfileById $getUser;

    public function __construct()
    {
        parent::__construct();

        $this->auth = new AuthAdapter();

        $bannerRepository = new BannersRepository();
        $attractionsRepo = new AttractionDAODatabase($this->dbConnection, $this->time);
        $comediansRepo = new ComedianDAODatabase($this->dbConnection, $this->time);
        $userRepo = new UserDAODatabase($this->dbConnection, $this->time);

        $this->attractionsByLocation = new ListAttractionsByLocation($attractionsRepo);
        $this->getLastAttractions = new GetLastAttractions($attractionsRepo);
        $this->getAllComedians = new GetAllComedians($comediansRepo);
        $this->getBanners = new GetBannersByScreen($bannerRepository);
        $this->getUser = new GetUserProfileById($userRepo, $comediansRepo);


    }

    /**
     * @OA\Get(
     *   path="/api/v1/home",
     *   tags={"comedian"},
     *   operationId="HomeController@handle",
     *   description="Returns all home data",
     *   security={ {"token": {} }},
     *   @OA\Response(
     *     response=200,
     *     description="Successful Operation",
     *   ),
     *   @OA\Response(response=404, description="Not found operation"),
     * )
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function handle(Request $request)
    {
        try {

            $limit = (int) $request->limit;

            $userId = $this->auth->auth->user();
            $user = $userId ? $this->getUser->handle($userId->getAuthIdentifier()) : $userId;

            $allComedians = $this->getAllComedians->handle();

            $nextAttractions = $this->attractionsByLocation->handle($request->lat, $request->lng, self::DEFAULT_DISTANCE);
            $lastAttractions = $this->getLastAttractions->handle($limit);

            $banners = $this->getBanners->handle(self::HOME);
            // limit 8 items

            $response = [
                "attractionsByLocation" => $nextAttractions,
                "banners" => $banners,
                "hotComedians" => [],
                "lastComedians" => $allComedians,
                "lastAttractions" => $lastAttractions,
                "user" => $user

            ];

            return $this->response->successResponse($response);

        } catch (Exception $exception) {
            return $this->response->badRequestResponse($exception->getMessage());
        }
    }
}
