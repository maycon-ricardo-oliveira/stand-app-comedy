<?php

namespace App\Chore\Modules\HotContent\Entities;

interface HotContentRepository
{
    public function saveHotContent(HotContent $hotContent): bool;
}
