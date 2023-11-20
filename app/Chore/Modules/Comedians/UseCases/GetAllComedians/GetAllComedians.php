<?php

namespace App\Chore\Modules\Comedians\UseCases\GetAllComedians;

use App\Chore\Modules\Comedians\Entities\ComedianRepository;

class GetAllComedians
{

    private ComedianRepository $comedianRepository;

    public function __construct(ComedianRepository $comedianRepository)
    {
        $this->comedianRepository = $comedianRepository;
    }

    public function handle()
    {
        return $this->comedianRepository->getAllComedians();
    }

}
