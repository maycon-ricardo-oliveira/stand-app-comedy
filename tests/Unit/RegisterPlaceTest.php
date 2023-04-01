<?php

namespace Tests\Unit;

use App\Chore\Modules\Adapters\DateTimeAdapter\DateTimeAdapter;
use App\Chore\Modules\Adapters\UuidAdapter\UniqIdAdapter;
use App\Chore\Modules\Attractions\Infra\Memory\AttractionRepositoryMemory;
use App\Chore\Modules\Places\Entities\PlaceRepository;
use App\Chore\Modules\Places\Infra\Memory\PlaceRepositoryMemory;
use App\Chore\Modules\Places\UseCases\RegisterPlace\RegisterPlace;
use App\Chore\Modules\User\Infra\Memory\UserRepositoryMemory;

class RegisterPlaceTest extends UnitTestCase
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

    public function basePlaceData(): array
    {
        return [
            "attractionId" => "63a277fc7b250",
            "userId" => "any_id_1",
            "tickets" => 10,
            "ticketsSold" => 0,
            "ticketsValidated" => 0,
            "startAt" => "20:00:00",
            "finishAt" => "21:00:00",
            "status" => "draft",
        ];
    }

    public function testRegisterPlace()
    {
        $useCase = new RegisterPlace(
            $this->placeRepo,
            $this->date,
            $this->uuid,
        );

        $placeData = [
            "name" => "Espaço Cultural Urca",
            "seats" => 200,
            "address" => "Av. Salim Farah Maluf, 1850 - Quarta Parada, SP",
            "zipcode" => "03157-200",
            "image" => "https://image.com/image.jpg",
            "lat" => -23.546185,
            "lng" => -46.579876,
            "distance" => 10,
        ];

        $result = $useCase->handle($placeData);

        $this->assertSame($placeData['name'], $result->name);
        $this->assertSame($placeData['seats'], $result->seats);
        $this->assertSame($placeData['address'], $result->address);
        $this->assertSame($placeData['zipcode'], $result->zipcode);

    }
}
