<?php

namespace App\Chore\UseCases\ListAttractionsByComedian;

use App\Chore\Domain\AttractionRepository;

class ListAttractionsByComedian
{

    private AttractionRepository $repo;

    public function __construct(AttractionRepository $repository)
    {
        $this->repo = $repository;
    }

    public function handle(string $comedian)
    {
        return $this->repo->getAttractionsByComedian($comedian);
    }
}
