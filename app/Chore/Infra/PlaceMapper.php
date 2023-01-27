<?php

namespace App\Chore\Infra;

use App\Chore\Domain\Place;
use Exception;

class PlaceMapper extends \ArrayIterator
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    public function mapper($userData = [])
    {

        if ($userData == []) {
            return $userData;
        }

        return array_map(function ($item) {
            $item = (object) $item;
            return new Place(
                $item->id,
                $item->name,
                $item->seats,
                $item->address,
                $item->zipcode,
                $item->lat,
                $item->lng,
                $item->distance
            );

        }, $userData);

    }

}
