<?php

namespace App\Chore\Domain;


class Attraction
{
    public string $id;
    public string $title;
    public IDateTime $date;
    public string $artist;
    public null|IDateTime $timeToEvent;
    public Place $place;

    /**
     * @param string $id
     * @param string $title
     * @param IDateTime $date
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

    public function getAmountTimeAtAttraction(IDateTime $time, IDateTime $date)
    {
        var_dump($date);
        var_dump($time);
        var_dump($date->diff($time));

        // payment on a future always must be true
        if ($date >= $time) return true;

        $difference = $time->diff($date, true);

        var_dump($difference);

        return false;


        // TODO: Verificar corretamente se a tava do evento já se passou
        return $date <= $time;

    }

}
