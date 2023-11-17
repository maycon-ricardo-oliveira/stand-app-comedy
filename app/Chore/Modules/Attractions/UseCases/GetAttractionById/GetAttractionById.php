<?php

namespace App\Chore\Modules\Attractions\UseCases\GetAttractionById;

use App\Chore\Modules\Attractions\Entities\Attraction;
use App\Chore\Modules\Attractions\Entities\AttractionRepository;

class GetAttractionById
{

    private AttractionRepository $repo;

    public function __construct(AttractionRepository $repository)
    {
        $this->repo = $repository;
    }

    /**
     * @throws \Exception
     */
    public function handle(string $attractionId)
    {
        $response =  $this->repo->findAttractionById($attractionId);

        if (!$response instanceof Attraction) {
            throw new \Exception('Attraction not found');
        }

        return $response;
    }

}
