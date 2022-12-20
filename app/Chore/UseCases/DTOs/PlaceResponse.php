<?php

namespace App\Chore\UseCases\DTOs;

/**
 * @OA\Schema(
 *   schema="PlaceResponse",
 *   description="Attraction",
 *   title="Place Schema",
 *   @OA\Property(property="id", type="string", description="The place id"),
 *   @OA\Property(property="name", type="string", description="The place name"),
 *   @OA\Property(property="address", type="string", description="The place address"),
 *   @OA\Property(property="zipcode", type="string", description="The place zipcode"),
 *   @OA\Property(property="lat", type="string", description="The place lat"),
 *   @OA\Property(property="lng", type="string", description="The place lng"),
 *   @OA\Property(property="distance", type="string", description="The place distance"),
 * )
 */

class PlaceResponse
{
    public string $id;
    public string $name;
    public string $address;
    public string $zipcode;
    public string $lat;
    public string $lng;
    public string $distance;

    /**
     * @param string $place_id
     * @param string $name
     * @param string $address
     * @param string $zipcode
     * @param string $lat
     * @param string $lng
     * @param string $distance
     */
    public function __construct(string $place_id, string $name, string $address, string $zipcode, string $lat, string $lng, string $distance)
    {
        $this->id = $place_id;
        $this->name = $name;
        $this->address = $address;
        $this->zipcode = $zipcode;
        $this->lat = $lat;
        $this->lng = $lng;
        $this->distance = $distance;
    }

}
