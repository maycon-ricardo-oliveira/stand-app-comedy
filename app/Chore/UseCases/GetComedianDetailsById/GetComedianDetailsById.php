<?php

namespace App\Chore\UseCases\GetComedianDetailsById;

use App\Chore\Domain\ComedianRepository;

class GetComedianDetailsById
{

    private ComedianRepository $comedianRepository;

    public function __construct(ComedianRepository $comedianRepository)
    {
        $this->comedianRepository = $comedianRepository;
    }

    public function handle(string $id)
    {

        $comedians = $this->comedianRepository->getComedianById($id);

        return $comedians;
    }

}
