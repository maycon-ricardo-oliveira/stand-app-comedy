<?php

namespace App\Chore\Modules\Attractions\UseCases\RegisterAttraction;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Domain\Comedian;
use App\Chore\Domain\ComedianRepository;
use App\Chore\Domain\IDateTime;
use App\Chore\Domain\IUniqId;
use App\Chore\Domain\Place;
use App\Chore\Domain\PlaceRepository;
use App\Chore\Domain\User;
use App\Chore\Domain\UserRepository;
use App\Chore\Modules\Attractions\Entities\Attraction;
use App\Chore\Modules\Attractions\Entities\AttractionRepository;
use App\Models\Enums\AttractionStatus;

class RegisterAttraction
{
    private AttractionRepository $repository;
    private ComedianRepository $comedianRepo;
    private UserRepository $userRepo;
    private PlaceRepository $placeRepo;
    private IUniqId $uuid;
    public function __construct(
        AttractionRepository $repository,
        ComedianRepository $comedianRepo,
        PlaceRepository $placeRepo,
        UserRepository $userRepo,
        IUniqId $uuid
    ) {
        $this->repository = $repository;
        $this->comedianRepo = $comedianRepo;
        $this->userRepo = $userRepo;
        $this->placeRepo = $placeRepo;
        $this->uuid = $uuid;
    }

    /**
     * @throws \Exception
     */
    public function handle($attractionData, IDateTime $time)
    {

        $comedian = $this->comedianRepo->getComedianById($attractionData['comedianId']);
        $place = $this->placeRepo->getPlaceById($attractionData['placeId']);
        $owner = $this->userRepo->findUserById($attractionData['ownerId']);

        if (!$comedian instanceof Comedian) {
            throw new \Exception('Comedian not found');
        }
        if (!$place instanceof Place) {
            throw new \Exception('Place not found');
        }
        if (!$owner instanceof User) {
            throw new \Exception('User not found');
        }

        $date = new DateTimeAdapter($attractionData["date"]);

        $attraction = new Attraction(
            $this->uuid->id(),
            $attractionData["title"],
            $date,
            $attractionData["duration"],
            $comedian,
            $place,
            in_array($attractionData["status"], AttractionStatus::$status) ?? AttractionStatus::DRAFT,
            $owner->id,
            $time
        );

        $response = $this->repository->registerAttraction($attraction, $time);

        return $response ? $attraction : null;
    }
}
