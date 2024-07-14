<?php

namespace App\Chore\Modules\HotContent\Entities;

class HotContent
{

    public string $id;
    public string $contentId;
    public ContentType $contentType;


    /**
     * @param string $id
     * @param string $contentId
     * @param ContentType $contentType
     */
    public function __construct(string $id, string $contentId, ContentType $contentType)
    {
        $this->id = $id;
        $this->contentId = $contentId;
        $this->contentType = $contentType;
    }


}
