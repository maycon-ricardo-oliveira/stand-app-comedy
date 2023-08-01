<?php

namespace App\Chore\Modules\Comedians\Infra;

use App\Chore\Modules\Comedians\Entities\Comedian;
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
                $item['thumbnail'] ?? '',
                $item['imageMain'] ?? '',
                $item['onFire'] ?? false,
                $item['metas'] ?? [],
                $item['socialMedias'] ?? []
            );
        }, $comediansData);

    }
}
