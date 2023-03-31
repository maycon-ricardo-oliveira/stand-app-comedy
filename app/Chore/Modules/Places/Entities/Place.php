<?php

namespace App\Chore\Modules\Places\Entities;

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

    /**
     * @param string $id
     * @param string $name
     * @param string $address
     * @param string $zipcode
     * @param string $lat
     * @param string $lng
     * @param string $distance
     */
    public function __construct(string $id, string $name, int $seats, string $address, string $zipcode, string $lat, string $lng, string $distance = '')
    {
        $this->id = $id;
        $this->name = $name;
        $this->seats = $seats;
        $this->address = $address;
        $this->zipcode = $zipcode;
        $this->lat = $lat;
        $this->lng = $lng;
        $this->distance = $distance;
    }

}
