<?php

namespace App\Chore\Modules\Banners\Entities;

use App\Chore\Modules\Banners\Exceptions\InvalidBannerStatusException;

class BannerStatus
{
    const ACTIVE = 'active';
    const INACTIVE = 'inactive';

    public function __construct(string $status)
    {
        if (!self::isValidStatus($status)) {
            throw new InvalidBannerStatusException();
        }

        $this->status = $status;
    }

    private static function isValidStatus(string $status): bool
    {
        return in_array($status, [self::ACTIVE, self::INACTIVE]);
    }

}
