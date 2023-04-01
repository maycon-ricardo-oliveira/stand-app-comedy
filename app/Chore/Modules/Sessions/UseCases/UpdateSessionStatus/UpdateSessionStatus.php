<?php

namespace App\Chore\Modules\Sessions\UseCases\UpdateSessionStatus;

use App\Chore\Modules\Attractions\Entities\Attraction;
use App\Chore\Modules\Attractions\Entities\AttractionRepository;
use App\Chore\Modules\Attractions\Exceptions\AttractionNotFoundException;
use App\Chore\Modules\Attractions\Exceptions\CantPossibleUpdateSessionException;
use App\Chore\Modules\Session\Exceptions\SessionNotFoundException;
use App\Chore\Modules\Sessions\Entities\Session;
use App\Chore\Modules\Sessions\Entities\SessionRepository;
use App\Chore\Modules\Sessions\Entities\SessionStatus;
use App\Chore\Modules\Sessions\Exceptions\InvalidSessionStatusException;
use App\Chore\Modules\Sessions\Exceptions\InvalidSessionStatusTransitionException;
use function Symfony\Component\Translation\t;

class UpdateSessionStatus
{
    private SessionRepository $repository;
    private AttractionRepository $attractionRepository;

    /**
     * @param SessionRepository $repository
     */
    public function __construct(SessionRepository $repository, AttractionRepository $attractionRepository )
    {
        $this->repository = $repository;
        $this->attractionRepository = $attractionRepository;
    }

    /**
     * @throws SessionNotFoundException
     * @throws InvalidSessionStatusException
     * @throws InvalidSessionStatusTransitionException
     * @throws CantPossibleUpdateSessionException
     * @throws AttractionNotFoundException
     */
    public function handle($sessionId, $status): ?Session
    {
        $session = $this->repository->findSessionById($sessionId);

        if (!$session instanceof Session) {
            throw new SessionNotFoundException();
        }

        $attraction = $this->attractionRepository->findAttractionById($session->attractionId);

        if (!$attraction instanceof Attraction) {
            throw new AttractionNotFoundException();
        }

        $attraction->canUpdateSessionStatus();

        $sessionActualStatus = new SessionStatus($session->status);
        $sessionStatus = new SessionStatus($status);

        if (!$sessionActualStatus->canTransitionTo($sessionStatus)) {
            throw new InvalidSessionStatusTransitionException();
        }

        $session->status = $sessionStatus->getStatus();
        $response = $this->repository->update($session);

        return $response ? $session : null;

    }

}
