<?php

namespace App\Chore\Modules\User\UseCases\RegisterLocation;

use App\Chore\Modules\Adapters\UuidAdapter\IUniqId;
use App\Chore\Modules\User\Entities\Location;
use App\Chore\Modules\User\Entities\User;
use App\Chore\Modules\User\Entities\UserRepository;
use Exception;

class RegisterLocation
{
    private UserRepository $repo;
    private IUniqId $uuId;

    public function __construct(UserRepository $repo, IUniqId $uuId)
    {
        $this->repo = $repo;
        $this->uuId = $uuId;
    }

    /**
     * @throws Exception
     */
    public function handle($locationData): bool
    {

        $location = new Location(
            $this->uuId->id(),
            $locationData["userId"],
            $locationData["street"],
            $locationData["neighbourhood"],
            $locationData["city"],
            $locationData["state"],
            $locationData["country"],
            $locationData["zipcode"],
            $locationData["formattedAddress"],
            $locationData["lat"],
            $locationData["lng"],
        );

        $user = $this->repo->findUserById($location->userId);

        if (!$user instanceof User) {
            throw new Exception("User not found");
        }

        $this->repo->registerLocation($location, $user);

        return true;
    }

}