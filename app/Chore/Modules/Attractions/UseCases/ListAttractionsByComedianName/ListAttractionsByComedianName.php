<?php

namespace App\Chore\Modules\Attractions\UseCases\ListAttractionsByComedianName;

use App\Chore\Modules\Attractions\Entities\AttractionRepository;

class ListAttractionsByComedianName
{

    private AttractionRepository $repo;

    public function __construct(AttractionRepository $repository)
    {
        $this->repo = $repository;
    }

    public function handle(string $comedianName)
    {
        return $this->repo->getAttractionsByComedianName($comedianName);
    }
}
