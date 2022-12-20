<?php

namespace App\Chore\UseCases\DTOs;

    /**
     * @OA\Schema(
     *   schema="Attraction",
     *   description="Attraction",
     *   title="Attraction Schema",
     *   @OA\Property(property="id", type="string", description="The attraction id"),
     *   @OA\Property(property="title", type="string", description="The attraction title"),
     *   @OA\Property(property="date", type="string", description="The attraction description"),
     *   @OA\Property(property="place", type="string", description="The attraction publisher"),
     *   @OA\Property(property="artist", type="string", description="The attraction isbn"),
     * )
     */


class AttractionResponse
{
    public string $id;
    public string $title;
    public string $date;
    public string $artist;

    /**
     * @param string $id
     * @param string $title
     * @param string $date
     * @param string $artist
     */
    public function __construct(string $id, string $title, string $date, string $artist)
    {
        $this->id = $id;
        $this->title = $title;
        $this->date = $date;
        $this->artist = $artist;
    }
}
