<?php

namespace App\Chore\Modules\Pathfinder\Entities;

abstract class Pathfinder implements AttractionFinderGateway
{

    abstract public function getAttractions($page = 1);
    abstract public function getComedian();
    abstract public function getPlace();

}
