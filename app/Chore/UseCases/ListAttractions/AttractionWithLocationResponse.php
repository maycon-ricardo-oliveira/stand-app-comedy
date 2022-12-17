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
 * )
 */
// TODO: add place schema on this response

class AttractionWithLocationResponse
{
    public string $id;
    public string $artist;
    public string $date;
    public string $title;
    public PlaceResponse $place;

    /**
     * @param string $id
     * @param string $artist
     * @param string $date
     * @param string $title
     * @param PlaceResponse $place

     */
    public function __construct(string $id, string $artist, string $date, string $title, PlaceResponse $place)
    {
        $this->id = $id;
        $this->artist = $artist;
        $this->date = $date;
        $this->title = $title;
        $this->place = $place;
    }

}
