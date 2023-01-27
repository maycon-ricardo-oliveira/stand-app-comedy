<?php

namespace App\Models\Enums;

class AttractionStatus
{
    const DRAFT = 'draft';
    const PUBLISHED = 'published';
    const FINISH = 'finish';

    public static $status = [self::DRAFT, self::PUBLISHED, self::FINISH];
}

