<?php

namespace App\Chore\Modules\Types\Time;

use App\Chore\Exceptions\InvalidTimeException;

class ValidateTime
{
    public static function validate(string $time): Time
    {
        if (!preg_match('/^([01]\d|2[0-3]):([0-5]\d):([0-5]\d)$/', $time)) {
            throw new InvalidTimeException();
        }
        return new Time($time);
    }
}
