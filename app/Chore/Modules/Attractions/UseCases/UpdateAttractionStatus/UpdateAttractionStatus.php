<?php

namespace App\Chore\Modules\Attractions\UseCases\UpdateAttractionStatus;

use App\Chore\Modules\Attractions\Entities\Attraction;
use App\Chore\Modules\Attractions\Entities\AttractionRepository;
use App\Chore\Modules\Attractions\Entities\AttractionStatus;
use App\Chore\Modules\Attractions\Exceptions\AttractionNotFoundException;
use App\Chore\Modules\Attractions\Exceptions\InvalidAttractionStatusException;
use App\Chore\Modules\Attractions\Exceptions\InvalidAttractionStatusTransitionException;

class UpdateAttractionStatus
{

    private AttractionRepository $repository;

    public function __construct(
        AttractionRepository $repository,
    ) {
        $this->repository = $repository;
    }

    /**
     * @throws AttractionNotFoundException
     * @throws InvalidAttractionStatusTransitionException|InvalidAttractionStatusException
     */
    public function handle(string $attractionId, string $status): ?Attraction
    {

        $attraction = $this->repository->findAttractionById($attractionId);

        if (!$attraction instanceof Attraction) {
            throw new AttractionNotFoundException();
        }

        $attractionActualStatus = new AttractionStatus($attraction->status);
        $attractionStatus = new AttractionStatus($status);

        if (!$attractionActualStatus->canTransitionTo($attractionStatus)) {
            throw new InvalidAttractionStatusTransitionException();
        }

        $attraction->status = $attractionStatus->getStatus();
        $response = $this->repository->updateAttraction($attraction);

        return $response ? $attraction : null;

    }

}
