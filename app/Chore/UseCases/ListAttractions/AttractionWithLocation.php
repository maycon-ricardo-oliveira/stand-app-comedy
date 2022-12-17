<?php

namespace App\Chore\UseCases\ListAttractions;


/**
 * @OA\Schema(
 *   schema="AttractionWithLocation",
 *   description="Attraction",
 *   title="Attraction Schema",
 *   @OA\Property(property="id", type="string", description="The attraction id"),
 *   @OA\Property(property="artist", type="string", description="The attraction artist"),
 *   @OA\Property(property="place", type="string", description="The attraction place"),
 *   @OA\Property(property="date", type="string", description="The attraction date"),
 *   @OA\Property(property="title", type="string", description="The attraction title"),
 *   @OA\Property(property="place_id", type="string", description="The attraction place_id"),
 *   @OA\Property(property="name", type="string", description="The attraction name"),
 *   @OA\Property(property="address", type="string", description="The attraction address"),
 *   @OA\Property(property="zipcode", type="string", description="The attraction zipcode"),
 *   @OA\Property(property="lat", type="string", description="The attraction lat"),
 *   @OA\Property(property="lng", type="string", description="The attraction lng"),
 *   @OA\Property(property="distance", type="string", description="The attraction distance"),
 * )
 */


class AttractionWithLocation
{
    public string $id;
    public string $artist;
    public string $place;
    public string $date;
    public string $title;
    public string $place_id;
    public string $name;
    public string $address;
    public string $zipcode;
    public string $lat;
    public string $lng;
    public string $distance;

    /**
     * @param string $id
     * @param string $artist
     * @param string $place
     * @param string $date
     * @param string $title
     * @param string $place_id
     * @param string $name
     * @param string $address
     * @param string $zipcode
     * @param string $lat
     * @param string $lng
     * @param string $distance
     */
    public function __construct(string $id, string $artist, string $place, string $date, string $title, string $place_id, string $name, string $address, string $zipcode, string $lat, string $lng, string $distance)
    {
        $this->id = $id;
        $this->artist = $artist;
        $this->place = $place;
        $this->date = $date;
        $this->title = $title;
        $this->place_id = $place_id;
        $this->name = $name;
        $this->address = $address;
        $this->zipcode = $zipcode;
        $this->lat = $lat;
        $this->lng = $lng;
        $this->distance = $distance;
    }

}
