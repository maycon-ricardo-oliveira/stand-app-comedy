<?php

namespace App\Chore\UseCases\ListAttractionsByComedianName;

use App\Chore\Domain\AttractionRepository;

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
