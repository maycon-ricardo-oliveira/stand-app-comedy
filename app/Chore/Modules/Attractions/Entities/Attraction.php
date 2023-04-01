<?php

namespace App\Chore\Modules\Attractions\Entities;


use App\Chore\Modules\Adapters\DateTimeAdapter\IDateTime;
use App\Chore\Modules\Attractions\Exceptions\CantPossibleCreateSessionException;
use App\Chore\Modules\Attractions\Exceptions\CantPossibleUpdateSessionException;
use App\Chore\Modules\Comedians\Entities\Comedian;
use App\Chore\Modules\Places\Entities\Place;
use App\Chore\Modules\Sessions\Entities\SessionStatus;

class Attraction
{
    public string $id;
    public string $title;
    public IDateTime $date;
    public string $duration;
    public Comedian $comedian;
    public false|string $timeToEvent;
    public Place $place;
    public string $status;
    public string $owner;

    /**
     * @param string $id
     * @param string $title
     * @param IDateTime $date
     * @param int $duration
     * @param Comedian $comedian
     * @param Place $place
     * @param string $status
     * @param string $owner
     * @param IDateTime $time
     */
    public function __construct(
        string $id,
        string $title,
        IDateTime $date,
        string $duration,
        Comedian $comedian,
        Place $place,
        string $status,
        string $owner,
        IDateTime $time)
    {
        $this->id = $id;
        $this->title = $title;
        $this->date = $date;
        $this->duration = $duration;
        $this->comedian = $comedian;
        $this->timeToEvent = $this->getAmountTimeAtAttraction($time, $date);
        $this->place = $place;
        $this->status = $status;
        $this->owner = $owner;
    }

    public function getAmountTimeAtAttraction(IDateTime $time, IDateTime $date): false|string
    {
        if ($date <= $time) return false;
        return $date->diff($time, true)->format('%a days and %h:%i hours');
    }

    /**
     * @throws CantPossibleCreateSessionException
     */
    public function canCreateSession(): bool
    {
        if (!in_array($this->status, [AttractionStatus::DRAFT, AttractionStatus::PUBLISHED])) {
            throw new CantPossibleCreateSessionException();
        }
        return true;
    }

    /**
     * @throws CantPossibleUpdateSessionException
     */
    public function canUpdateSessionStatus(): bool
    {
        if (!in_array($this->status, [AttractionStatus::PUBLISHED])) {
            throw new CantPossibleUpdateSessionException();
        }
        return true;
    }

}
