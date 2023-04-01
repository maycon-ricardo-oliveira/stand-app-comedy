<?php

namespace App\Chore\Modules\Places\Entities;

use App\Chore\Modules\Types\Url\Url;

class Place
{
    public string $id;
    public string $name;
    public int $seats;
    public string $address;
    public string $zipcode;
    public string $lat;
    public string $lng;
    public string $distance;
    public Url $image;

    /**
     * @param string $id
     * @param string $name
     * @param int $seats
     * @param string $address
     * @param string $zipcode
     * @param Url $image
     * @param string $lat
     * @param string $lng
     * @param string $distance
     */
    public function __construct(string $id, string $name, int $seats, string $address, string $zipcode,  Url $image, string $lat, string $lng, string $distance = '')
    {
        $this->id = $id;
        $this->name = $name;
        $this->seats = $seats;
        $this->address = $address;
        $this->zipcode = $zipcode;
        $this->lat = $lat;
        $this->lng = $lng;
        $this->distance = $distance;
        $this->image = $image;
    }

}
