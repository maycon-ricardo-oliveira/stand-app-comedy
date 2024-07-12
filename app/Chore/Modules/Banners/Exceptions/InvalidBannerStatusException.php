<?php

namespace App\Chore\Modules\Banners\Exceptions;

use Throwable;

class InvalidBannerStatusException extends \Exception {
    public function __construct(string $message = 'Invalid banner status', int $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
