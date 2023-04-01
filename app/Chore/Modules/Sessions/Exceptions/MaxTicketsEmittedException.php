<?php

namespace App\Chore\Modules\Sessions\Exceptions;

use Exception;
use Throwable;

class MaxTicketsEmittedException extends Exception {
    public function __construct(string $message = 'Max tickets emitted', int $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }

}
