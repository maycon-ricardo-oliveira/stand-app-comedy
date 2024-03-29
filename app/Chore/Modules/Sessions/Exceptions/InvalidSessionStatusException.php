<?php

namespace App\Chore\Modules\Sessions\Exceptions;

use Exception;
use Throwable;

class InvalidSessionStatusException extends Exception
{
    public function __construct(string $message = 'Invalid session status', int $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }

}
