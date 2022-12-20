<?php

namespace App\Chore\UseCases\ListAttractions;

use App\Chore\Domain\AttractionRepository;

class ListAttractions
{

    /**
     * @var AttractionRepository
     */
    private AttractionRepository $attractionRepo;

    public function __construct(AttractionRepository $attractionRepo)
    {
        $this->attractionRepo = $attractionRepo;
    }

    public function handle(string $place): array
    {
        return $this->attractionRepo->getAttractionsInAPlace($place);
    }

}
