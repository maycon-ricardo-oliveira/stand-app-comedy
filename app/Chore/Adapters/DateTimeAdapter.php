<?php

namespace App\Chore\Adapters;

use App\Chore\Domain\IDateTime;
use DateTimeImmutable;

/**
 * @OA\Schema(
 *   schema="DateTimeResponse",
 *   description="DateTime",
 *   title="DateTime Schema",
 *   @OA\Property(property="date", type="string", description="The date date"),
 *   @OA\Property(property="timezone_type", type="int", description="The date timezone_type"),
 *   @OA\Property(property="timezone", type="string", description="The date timezone"),
 * )
 */

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
