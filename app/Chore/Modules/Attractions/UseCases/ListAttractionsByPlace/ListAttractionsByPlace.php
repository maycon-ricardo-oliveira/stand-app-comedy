<?php

namespace App\Chore\Modules\Attractions\UseCases\ListAttractionsByPlace;

use App\Chore\Modules\Attractions\Entities\AttractionRepository;

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
