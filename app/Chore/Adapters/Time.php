<?php

namespace App\Chore\Adapters;

class Time
{
    private string $time;

    public function __construct(string $time)
    {
        $this->time = $time;
    }

    public function getTime(): string
    {
        return $this->time;
    }

}
