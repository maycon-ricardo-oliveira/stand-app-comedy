<?php

namespace App\Chore\Domain;


class Attraction
{
    public string $id;
    public string $title;
    public string $date;
    public string $artist;
    public Place $place;

    /**
     * @param string $id
     * @param string $title
     * @param string $date
     * @param string $artist
     * @param Place $place
     */
    public function __construct(string $id, string $title, string $date, string $artist, Place $place)
    {
        $this->id = $id;
        $this->title = $title;
        $this->date = $date;
        $this->artist = $artist;
        $this->place = $place;
    }

}
