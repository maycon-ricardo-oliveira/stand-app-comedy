<?php

namespace App\Chore\Modules\Sessions\UseCases\RegisterSession;

use App\Chore\Exceptions\InvalidTimeException;
use App\Chore\Exceptions\UserNotFoundException;
use App\Chore\Modules\Adapters\DateTimeAdapter\IDateTime;
use App\Chore\Modules\Adapters\UuidAdapter\IUniqId;
use App\Chore\Modules\Adapters\UuidAdapter\UniqIdAdapter;
use App\Chore\Modules\Attractions\Entities\Attraction;
use App\Chore\Modules\Attractions\Entities\AttractionRepository;
use App\Chore\Modules\Attractions\Exceptions\AttractionNotFoundException;
use App\Chore\Modules\Sessions\Entities\Session;
use App\Chore\Modules\Sessions\Entities\SessionCode;
use App\Chore\Modules\Sessions\Entities\SessionRepository;
use App\Chore\Modules\Types\Time\ValidateTime;
use App\Chore\Modules\User\Entities\User;
use App\Chore\Modules\User\Entities\UserRepository;
use App\Chore\Modules\User\Infra\Memory\UserRepositoryMemory;

class RegisterSession
{
    private SessionRepository $repository;
    private AttractionRepository $attractionRepo;
    private UserRepository $userRepo;
    private UniqIdAdapter $uuid;

    /**
     * @param AttractionRepository $attractionRepo
     * @param SessionRepository $sessionRepository
     * @param UserRepositoryMemory $userRepo
     * @param IUniqId $uuid
     */
    public function __construct(SessionRepository $sessionRepository, AttractionRepository $attractionRepo, UserRepository $userRepo, IUniqId $uuid)
    {
        $this->repository = $sessionRepository;
        $this->attractionRepo = $attractionRepo;
        $this->userRepo = $userRepo;
        $this->uuid = $uuid;
    }

    /**
     * @throws UserNotFoundException
     * @throws AttractionNotFoundException|InvalidTimeException
     */
    public function handle(array $session, IDateTime $date)
    {
        $attraction = $this->attractionRepo->findAttractionById($session['attractionId']);
        $owner = $this->userRepo->findUserById($session['userId']);

        if (!$attraction instanceof Attraction) {
            throw new AttractionNotFoundException();
        }

        if (!$owner instanceof User) {
            throw new UserNotFoundException();
        }

        $session = new Session(
            $this->uuid->id(),
            $attraction->id,
            SessionCode::generate($attraction->title, $date),
            $session["tickets"],
            $session["ticketsSold"],
            $session["ticketsValidated"],
            ValidateTime::validate($session["startAt"]),
            ValidateTime::validate($session["finishAt"]),
            $session["status"],
            $owner->id,
            $date,
            $date,
        );

        return $this->repository->register($session) ? $session : null;
    }
}
