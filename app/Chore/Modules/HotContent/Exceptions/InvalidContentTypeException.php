<?php

namespace App\Chore\Modules\HotContent\Exceptions;

use Throwable;

class InvalidContentTypeException extends \Exception {
    public function __construct(string $message = 'Invalid content type', int $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
