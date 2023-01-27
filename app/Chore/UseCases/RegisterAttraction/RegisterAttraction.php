<?php

namespace App\Chore\UseCases\RegisterAttraction;

use App\Chore\Domain\AttractionRepository;

class RegisterAttraction
{

    private AttractionRepository $repository;

    public function __construct(AttractionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle()
    {

    }
}
