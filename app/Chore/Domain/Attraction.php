<?php

namespace App\Chore\Domain;


class Attraction
{
    public string $id;
    public string $title;
    public string $date;
    public string $place;
    public string $artist;

    /**
     * @param string $id
     * @param string $title
     * @param string $date
     * @param string $place
     * @param string $artist
     */
    public function __construct(string $id, string $title, string $date, string $place, string $artist)
    {
        $this->id = $id;
        $this->title = $title;
        $this->date = $date;
        $this->place = $place;
        $this->artist = $artist;
    }

}
