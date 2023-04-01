<?php

namespace App\Chore\Modules\Places\Infra;

use App\Chore\Modules\Places\Entities\Place;
use App\Chore\Modules\Types\Url\Url;
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
                new Url($item->image),
                $item->lat,
                $item->lng,
                $item->distance ?? ''
            );

        }, $userData);

    }

}
