<?php

namespace App\Chore\Modules\Banners\Infra;

use App\Chore\Modules\Banners\Entities\Banner;
use App\Chore\Modules\Banners\Entities\BannerRepository;
use App\Chore\Modules\Banners\Entities\BannerStatus;
use App\Models\Banners;
use DateTimeImmutable;

class BannersRepository implements BannerRepository
{

    public function getBannersByScreen(string $screen)
    {
        $banners = Banners::where(['screen' => $screen])->get();

        $response = [];

        foreach ($banners as $banner) {
            $response[] = new Banner(
                $banner->id,
                $banner->name,
                $banner->image,
                $banner->url,
                new BannerStatus($banner->status),
                $banner->type,
                $banner->screen,
                new DateTimeImmutable($banner->start_date),
                new DateTimeImmutable($banner->end_dat),


            );
        }
        return $response;
    }
}
