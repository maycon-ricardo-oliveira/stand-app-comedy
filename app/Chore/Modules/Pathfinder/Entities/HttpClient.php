<?php

namespace App\Chore\Modules\Pathfinder\Entities;

interface HttpClient
{
    public function get($url);
    public function post($url);
}
