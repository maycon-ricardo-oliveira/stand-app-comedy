<?php

namespace App\Chore\Exceptions;

use Throwable;

class InvalidDateException extends \Exception {
    public function __construct(string $message = 'Invalid date', int $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
