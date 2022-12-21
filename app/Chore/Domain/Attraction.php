<?php

namespace App\Chore\Domain;


class Attraction
{
    public string $id;
    public string $title;
    public IDateTime $date;
    public Comedian $comedian;
    public false|string $timeToEvent;
    public Place $place;

    /**
     * @param string $id
     * @param string $title
     * @param IDateTime $date
     * @param IDateTime $time
     * @param Comedian $comedian
     * @param Place $place
     */
    public function __construct(string $id, string $title, IDateTime $date, Comedian $comedian, Place $place, IDateTime $time)
    {
        $this->id = $id;
        $this->title = $title;
        $this->comedian = $comedian;
        $this->date = $date;
        $this->place = $place;
        $this->timeToEvent = $this->getAmountTimeAtAttraction($time, $date);
    }

    public function getAmountTimeAtAttraction(IDateTime $time, IDateTime $date): false|string
    {
        if ($date <= $time) return false;
        return $date->diff($time, true)->format('%a days and %h:%i hours');
    }

}
