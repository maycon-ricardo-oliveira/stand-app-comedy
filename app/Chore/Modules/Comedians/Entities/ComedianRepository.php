<?php

namespace App\Chore\Modules\Comedians\Entities;

use App\Chore\Modules\Adapters\DateTimeAdapter\IDateTime;

interface ComedianRepository
{
    public function getComedianById(string $id): ?Comedian;
    public function getComedianByName(string $name): ?Comedian;
    public function getListOfComedians(array $comedianIds);
    public function register(Comedian $comedian);
    public function registerMeta(ComedianMeta $comedianMeta);
    public function getComedianMetas(string $id): array;

    public function getAllComedians();

}
