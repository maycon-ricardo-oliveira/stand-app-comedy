<?php

namespace App\Chore\UseCases\ListAttractionsByLocation;


use App\Chore\Domain\AttractionRepository;


class ListAttractionsByLocation
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
    public function handle(string $lat, string $long, int $distance, $limit = 100): array
    {
        $attractions = $this->attractionRepo->getPlacesByLocation($lat, $long, $distance, $limit);

        return $attractions;

    }

}
