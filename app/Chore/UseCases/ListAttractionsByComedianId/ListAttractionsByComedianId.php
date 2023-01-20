<?php

namespace App\Chore\UseCases\ListAttractionsByComedianId;

use App\Chore\Domain\AttractionRepository;

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
