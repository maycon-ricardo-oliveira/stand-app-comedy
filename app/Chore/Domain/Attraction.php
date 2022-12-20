<?php

namespace App\Chore\Domain;


class Attraction
{
    public string $id;
    public string $title;
    public IDateTime $date;
    public string $artist;
    public false|string $timeToEvent;
    public Place $place;

    /**
     * @param string $id
     * @param string $title
     * @param IDateTime $date
     * @param IDateTime $time
     * @param string $artist
     * @param Place $place
     */
    public function __construct(string $id, string $title, IDateTime $date, IDateTime $time, string $artist, Place $place)
    {
        $this->id = $id;
        $this->title = $title;
        $this->date = $date;
        $this->artist = $artist;
        $this->place = $place;
        $this->timeToEvent = $this->getAmountTimeAtAttraction($time, $date);
    }

    public function getAmountTimeAtAttraction(IDateTime $time, IDateTime $date): false|string
    {

        if ($date <= $time) {
            return false;
        }

        return $date->diff($time, true)->format('%a days and %h:%i hours');

    }

}
