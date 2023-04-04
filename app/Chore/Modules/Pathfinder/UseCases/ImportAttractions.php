<?php

namespace App\Chore\Modules\Pathfinder\UseCases;

use App\Chore\Modules\Pathfinder\Entities\AttractionFinderGateway;
use App\Chore\Modules\Pathfinder\Entities\HttpClient;

class ImportAttractions
{
    private AttractionFinderGateway $attractionGateway;

    /**
     * @param AttractionFinderGateway $attractionGateway
     */
    public function __construct(AttractionFinderGateway $attractionGateway)
    {
        $this->attractionGateway = $attractionGateway;
    }

    public  function import()
    {
        $attractions = $this->attractionGateway->getAttractions();

        return $attractions;

    }



}
