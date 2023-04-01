<?php

namespace App\Chore\Modules\Places\UseCases\RegisterPlace;

use App\Chore\Modules\Adapters\DateTimeAdapter\IDateTime;
use App\Chore\Modules\Adapters\UuidAdapter\IUniqId;
use App\Chore\Modules\Places\Entities\Place;
use App\Chore\Modules\Places\Entities\PlaceRepository;
use App\Chore\Modules\Types\Url\Url;

class RegisterPlace
{

    private PlaceRepository $placeRepo;
    private IDateTime $time;
    private IUniqId $uuid;

    /**
     * @param PlaceRepository $placeRepo
     * @param IDateTime $time
     * @param IUniqId $uuid
     */
    public function __construct(PlaceRepository $placeRepo,  IDateTime $time, IUniqId $uuid)
    {
        $this->placeRepo = $placeRepo;
        $this->time = $time;
        $this->uuid = $uuid;

    }

    public function handle($placeData): ?Place
    {
        $place = new Place(
            $this->uuid->id(),
            $placeData["name"],
            $placeData["seats"],
            $placeData["address"],
            $placeData["zipcode"],
            new Url($placeData["image"]),
            $placeData["lat"],
            $placeData["lng"]
        );

        return $this->placeRepo->register($place) ? $place : null;
    }

}
