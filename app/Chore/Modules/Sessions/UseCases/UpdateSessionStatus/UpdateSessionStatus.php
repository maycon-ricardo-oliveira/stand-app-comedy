<?php

namespace App\Chore\Modules\Sessions\UseCases\UpdateSessionStatus;

use App\Chore\Modules\Session\Exceptions\SessionNotFoundException;
use App\Chore\Modules\Sessions\Entities\Session;
use App\Chore\Modules\Sessions\Entities\SessionRepository;
use App\Chore\Modules\Sessions\Entities\SessionStatus;
use App\Chore\Modules\Sessions\Exceptions\InvalidSessionStatusException;
use App\Chore\Modules\Sessions\Exceptions\InvalidSessionStatusTransitionException;

class UpdateSessionStatus
{
    private SessionRepository $repository;

    /**
     * @param SessionRepository $repository
     */
    public function __construct(SessionRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws SessionNotFoundException
     * @throws InvalidSessionStatusException
     * @throws InvalidSessionStatusTransitionException
     */
    public function handle($sessionId, $status): ?Session
    {
        $session = $this->repository->findSessionById($sessionId);

        if (!$session instanceof Session) {
            throw new SessionNotFoundException();
        }

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
