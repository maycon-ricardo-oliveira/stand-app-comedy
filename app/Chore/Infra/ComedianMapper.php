<?php

namespace App\Chore\Infra;

use App\Chore\Domain\Comedian;
use App\Chore\Domain\IDateTime;
use ArrayIterator;
use Exception;

class ComedianMapper extends ArrayIterator
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    public function mapper(IDateTime $time, $comediansData = [])
    {
        return $comediansData == [] ? $comediansData : array_map(function ($item) use ($time) {
            return new Comedian(
                $item['id'],
                $item['name'],
                $item['miniBio'],
                $item['socialMedias'],
                $item['attractions'],
            );

        }, $comediansData);

    }
}
