<?php

namespace App\Chore\Modules\HotContent\Entities;

use App\Chore\Modules\Banners\Exceptions\InvalidBannerStatusException;
use App\Chore\Modules\HotContent\Exceptions\InvalidContentTypeException;

class ContentType
{
    const HOT_COMEDIANS = 'hot_comedians';
    const HOT_ATTRACTIONS = 'hot_attractions';
    const HOT_PLACES = 'hot_places';
    public string $type;

    /**
     * @throws InvalidContentTypeException
     */
    public function __construct(string $type)
    {
        if (!self::isValidType($type)) {
            throw new InvalidContentTypeException();
        }

        $this->type = $type;
    }

    private static function isValidType(string $type): bool
    {
        return in_array($type, [self::HOT_COMEDIANS, self::HOT_ATTRACTIONS, self::HOT_PLACES]);
    }
}
