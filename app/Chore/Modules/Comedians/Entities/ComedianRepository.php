<?php

namespace App\Chore\Modules\Comedians\Entities;

interface ComedianRepository
{
    public function getComedianById(string $id);
    public function getListOfComedians(array $comedianIds);

}
