<?php

namespace Tests\Api;

use App\Chore\Modules\Adapters\DateTimeAdapter\DateTimeAdapter;
use App\Chore\Modules\Adapters\UuidAdapter\UniqIdAdapter;
use App\Chore\Modules\Attractions\Infra\Memory\AttractionRepositoryMemory;
use App\Chore\Modules\Places\Entities\PlaceRepository;
use App\Chore\Modules\Places\Infra\Memory\PlaceRepositoryMemory;
use App\Chore\Modules\User\Infra\Memory\UserRepositoryMemory;
use App\Http\Controllers\GetPlaceByIdController;
use App\Http\Controllers\RegisterPlaceController;
use Illuminate\Http\Request;

class PlacesControllerTest extends ApiTestCase
{

    private PlaceRepository $PlaceRepo;
    private AttractionRepositoryMemory $attractionRepo;
    private UserRepositoryMemory $userRepo;
    private UniqIdAdapter $uuid;

    private DateTimeAdapter $date;

    /**
     * @throws \Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->date = new DateTimeAdapter();
        $this->placeRepo = new PlaceRepositoryMemory();
        $this->uuid = new UniqIdAdapter();
    }

    public function testMustBeReturn200OnListAttractionsByComedianController()
    {
        $placeData = [
            "name" => "Espaço Cultural Urca",
            "seats" => 200,
            "address" => "Av. Salim Farah Maluf, 1850 - Quarta Parada, SP",
            "zipcode" => "03157-200",
            "lat" => -23.546185,
            "lng" => -46.579876,
            "distance" => 10,
        ];

        $request = new Request();
        $request->name = $placeData["name"];
        $request->seats = $placeData["seats"];
        $request->address = $placeData["address"];
        $request->zipcode = $placeData["zipcode"];
        $request->lat = $placeData["lat"];
        $request->lng = $placeData["lng"];
        $request->distance = $placeData["distance"];

        $controller = new RegisterPlaceController();
        $response = $controller->handle($request);

        $this->assertSame(200, $response->getData()->status);
        $this->assertIsObject($response->getData()->data);
        $this->assertSame($response->getData()->data->name, $request->name);

    }

    public function testMustBeReturn200OnGetPlaceByIdController()
    {
        $request = new Request();
        $request->placeId = "63d332d4be676";

        $controller = new GetPlaceByIdController();
        $response = $controller->handle($request);

        $this->assertSame(200, $response->getData()->status);
        $this->assertIsObject($response->getData()->data);
        $this->assertSame($response->getData()->data->id, $request->placeId);

    }

}
