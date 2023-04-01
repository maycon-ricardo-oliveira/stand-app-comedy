<?php

namespace App\Chore\Modules\Types\Url;

class Url
{
    public ?string $url;

    /**
     * @param string|null $url
     */
    public function __construct(?string $url = '')
    {
        $this->url = $url;
    }

}
