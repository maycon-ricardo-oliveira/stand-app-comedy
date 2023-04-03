<?php

namespace App\Chore\Modules\Sessions\Exceptions;

use Exception;
use Throwable;

class MaxTicketsValidatedException extends Exception {
    public function __construct(string $message = 'Max tickets validated', int $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }

}

