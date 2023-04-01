<?php

namespace App\Chore\Modules\Attractions\Exceptions;

use Exception;
use Throwable;

class CantPossibleUpdateSessionException extends Exception
{
    public function __construct(string $message = "Can't possible update session status", int $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
