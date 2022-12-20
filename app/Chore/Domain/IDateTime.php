<?php

namespace App\Chore\Domain;

interface IDateTime
{
    public function __construct($datetime = "now", $timezone  = null);

    public function diff($targetObject, $absolute = false);

}
