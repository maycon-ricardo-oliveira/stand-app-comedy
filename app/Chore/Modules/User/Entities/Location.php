<?php

namespace App\Chore\Modules\User\Entities;

class Location
{

    public string $id;
    public string $userId;
    public string $street;
    public string $neighbourhood;
    public string $city;
    public string $state;
    public string $country;
    public string $zipcode;
    public string $formattedAddress;
    public string $lat;
    public string $lng;

    /**
     * @param string $id
     * @param string $userId
     * @param string $street
     * @param string $neighbourhood
     * @param string $city
     * @param string $state
     * @param string $country
     * @param string $zipcode
     * @param string $formattedAddress
     * @param string $lat
     * @param string $lng
     */
    public function __construct(string $id, string $userId, string $street, string $neighbourhood, string $city, string $state, string $country, string $zipcode, string $formattedAddress, string $lat, string $lng)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->street = $street;
        $this->neighbourhood = $neighbourhood;
        $this->city = $city;
        $this->state = $state;
        $this->country = $country;
        $this->zipcode = $zipcode;
        $this->formattedAddress = $formattedAddress;
        $this->lat = $lat;
        $this->lng = $lng;
    }


}