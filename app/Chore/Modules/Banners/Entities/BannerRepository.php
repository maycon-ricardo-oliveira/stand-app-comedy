<?php

namespace App\Chore\Modules\Banners\Entities;

interface BannerRepository
{
    /**
     * @param string $screen
     * @return array
     */
    public function getBannersByScreen(string $screen);

}
