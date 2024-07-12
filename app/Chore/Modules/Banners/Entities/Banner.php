<?php

namespace App\Chore\Modules\Banners\Entities;

class Banner
{

    public string $id;
    public string $name;
    public string $image;
    public string $url;
    public BannerStatus $status;
    public string $type;
    public string $screen;
    public \DateTimeImmutable $startDate;
    public \DateTimeImmutable $endDate;

    /**
     * @param string $id
     * @param string $name
     * @param string $image
     * @param string $url
     * @param BannerStatus $status
     * @param string $type
     * @param string $screen
     * @param \DateTimeImmutable $startDate
     * @param \DateTimeImmutable $endDate
     */
    public function __construct(string $id, string $name, string $image, string $url, BannerStatus $status, string $type, string $screen, \DateTimeImmutable $startDate, \DateTimeImmutable $endDate)
    {
        $this->id = $id;
        $this->name = $name;
        $this->image = $image;
        $this->url = $url;
        $this->status = $status;
        $this->type = $type;
        $this->screen = $screen;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }
}
