<?php

namespace App\Chore\Modules\Pathfinder\Entities;


class AttractionsOutput
{
    public string $name;
    public string $placeName;
    public string $bannerImage;
    public string $date;
    public string $duration;
    public string $detailsUrl;

    /**
     * @param string $name
     * @param string $placeName
     * @param string $bannerImage
     * @param string $date
     * @param string $duration
     * @param string $detailsUrl
     */
    public function __construct(string $name, string $placeName, string $bannerImage, string $date, string $duration, string $detailsUrl)
    {
        $this->name = $name;
        $this->placeName = $placeName;
        $this->bannerImage = $bannerImage;
        $this->date = $date;
        $this->duration = $duration;
        $this->detailsUrl = $detailsUrl;
    }

}
