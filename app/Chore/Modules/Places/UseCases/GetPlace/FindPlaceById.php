<?php

namespace App\Chore\Modules\Places\UseCases\GetPlace;

use App\Chore\Modules\Places\Entities\PlaceRepository;

class FindPlaceById
{
    private PlaceRepository $placeRepo;

    public function __construct(PlaceRepository $placeRepo)
    {
        $this->placeRepo = $placeRepo;
    }

    public function handle($placeId)
    {
        $place = $this->placeRepo->getPlaceById($placeId);
        return $place;
    }
}
