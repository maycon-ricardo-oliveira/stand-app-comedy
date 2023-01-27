<?php

namespace App\Chore\UseCases\ListAttractionsByPlace;

use App\Chore\Domain\AttractionRepository;

class ListAttractionsByPlace
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
