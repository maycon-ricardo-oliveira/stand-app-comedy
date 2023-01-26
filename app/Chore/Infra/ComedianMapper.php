<?php

namespace App\Chore\Infra;

use App\Chore\Domain\Comedian;
use App\Chore\Domain\IDateTime;
use App\Chore\Domain\User;
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
    public function mapper($comediansData = [])
    {

        if ($comediansData == []) {
            return $comediansData;
        }

        return array_map(function ($item) {
            return new Comedian(
                $item['id'],
                $item['name'],
                $item['miniBio'],
                $item['socialMedias'] ?? []
            );
        }, $comediansData);

    }
}
