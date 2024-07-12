<?php

namespace App\Chore\Modules\Banners\UseCases;

use App\Chore\Modules\Banners\Entities\BannerRepository;

class GetBannersByScreen
{

    private BannerRepository $bannerRepo;


    public function __construct(BannerRepository $bannerRepo)
    {
        $this->bannerRepo = $bannerRepo;
    }

    public function handle(string $screen)
    {
        $response = $this->bannerRepo->getBannersByScreen($screen);

        return $response;
    }
}
