<?php

namespace App\Chore\Modules\Attractions\UseCases\GetLastAttractions;


use App\Chore\Modules\Attractions\Entities\AttractionRepository;


class GetLastAttractions
{
    private AttractionRepository $attractionRepo;

    /**
     * @param AttractionRepository $attractionRepo
     */
    public function __construct(AttractionRepository $attractionRepo)
    {
        $this->attractionRepo = $attractionRepo;
    }

    /**
     * @throws \Exception
     */
    public function handle($limit = 8): array
    {
        $attractions = $this->attractionRepo->getLastAttractions($limit);

        return $attractions;

    }

}
