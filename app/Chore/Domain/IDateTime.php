<?php

namespace App\Chore\Domain;

use DateTimeInterface;

interface IDateTime extends DateTimeInterface
{
    public function __construct($datetime = "now", $timezone  = null);

    public function diff($targetObject, $absolute = false);
    public function format(string $format = 'Y-m-d H:i:s'): string;

}
