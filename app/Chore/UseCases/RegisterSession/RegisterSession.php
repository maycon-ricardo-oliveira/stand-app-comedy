<?php

namespace App\Chore\UseCases\RegisterSession;

use App\Chore\Adapters\UniqIdAdapter;
use App\Chore\Adapters\ValidateTime;
use App\Chore\Domain\IDateTime;
use App\Chore\Domain\IUniqId;
use App\Chore\Domain\Session;
use App\Chore\Domain\SessionCode;
use App\Chore\Domain\SessionRepository;
use App\Chore\Domain\User;
use App\Chore\Domain\UserRepository;
use App\Chore\Exceptions\AttractionNotFoundException;
use App\Chore\Exceptions\UserNotFoundException;
use App\Chore\Infra\Memory\UserRepositoryMemory;
use App\Chore\Modules\Attractions\Entities\Attraction;
use App\Chore\Modules\Attractions\Entities\AttractionRepository;

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
     * @throws AttractionNotFoundException
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
