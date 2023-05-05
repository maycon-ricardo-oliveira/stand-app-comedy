<?php

namespace App\Chore\Modules\Comedians\Entities;

class Comedian
{
    public string $id;
    public string $name;
    public string $miniBio;
    public array $socialMedias;
    public array $attractions;
    public string $thumbnail;

    /**
     * @param string $id
     * @param string $name
     * @param string $miniBio
     * @param string $thumbnail
     * @param array $socialMedias
     * @param array $attractions
     */
    public function __construct(string $id, string $name, string $miniBio, string $thumbnail, array $socialMedias, array $attractions = [])
    {
        $this->id = $id;
        $this->name = $name;
        $this->miniBio = $miniBio;
        $this->socialMedias = $socialMedias;
        $this->attractions = $attractions;
        $this->thumbnail = $thumbnail;
    }

}
