<?php

namespace App\Chore\Modules\HotContent\Infra;

use App\Chore\Modules\HotContent\Entities\HotContent;
use App\Chore\Modules\HotContent\Entities\HotContentRepository;
use App\Models\HotContent as HotContentModel;

class HotContentsRepository implements HotContentRepository
{

    private \DateTimeImmutable $time;

    public function __construct(\DateTimeImmutable $time)
    {
        $this->time = $time;
    }

    public function saveHotContent(HotContent $hotContent): bool
    {
        HotContentModel::create([
            'id' => $hotContent->id,
            'content_type' => $hotContent->contentType->type,
            'content_id' => $hotContent->contentId,
            'created_at' => $this->time->format('Y-m-d H:i:s'),
            'updated_at' => $this->time->format('Y-m-d H:i:s')
        ]);
        return true;
    }
}
