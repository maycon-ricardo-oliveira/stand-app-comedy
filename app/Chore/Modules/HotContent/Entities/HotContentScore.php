<?php

namespace App\Chore\Modules\HotContent\Entities;

class HotContentScore
{
    public int $score;
    public ContentType $contentType;
    public $content;

    /**
     * @param int $score
     * @param ContentType $contentType
     * @param $content
     */
    public function __construct(int $score, ContentType $contentType, $content)
    {
        $this->score = $score;
        $this->contentType = $contentType;
        $this->content = $content;
    }


}
