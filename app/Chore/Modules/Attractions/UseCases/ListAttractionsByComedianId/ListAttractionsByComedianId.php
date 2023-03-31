<?php

namespace App\Chore\Modules\Attractions\UseCases\ListAttractionsByComedianId;

use App\Chore\Modules\Attractions\Entities\AttractionRepository;

class ListAttractionsByComedianId
{

    private AttractionRepository $repo;

    public function __construct(AttractionRepository $repository)
    {
        $this->repo = $repository;
    }

    public function handle(string $comedianId)
    {
        return $this->repo->getAttractionsByComedianId($comedianId);
    }
}
