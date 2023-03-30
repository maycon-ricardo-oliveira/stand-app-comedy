<?php

namespace App\Chore\Exceptions;

use Throwable;

class AttractionNotFoundException extends \Exception {
    public function __construct(string $message = 'Attraction not found', int $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
