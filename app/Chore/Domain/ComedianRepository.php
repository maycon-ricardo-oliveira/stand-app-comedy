<?php

namespace App\Chore\Domain;

interface ComedianRepository
{
    public function getComedianById(string $id);
    public function followComedian(User $user, Comedian $comedian);

}
