<?php

namespace App\Chore\Adapters;

use App\Chore\Domain\IDateTime;
use DateTimeImmutable;

class DateTimeAdapter extends DateTimeImmutable implements IDateTime
{

    public function __construct($datetime = "now", $timezone = null)
    {
        parent::__construct($datetime, $timezone);
    }

    public function diff($targetObject, $absolute = false)
    {
        return parent::diff($targetObject, $absolute);
    }

    public function modify($modifier): DateTimeAdapter|bool
    {
        return parent::modify($modifier);
    }

}
