<?php

namespace App\Chore\Modules\Attractions\Exceptions;

use Exception;
use Throwable;

class CantPossibleCreateSessionException extends Exception
{
    public function __construct(string $message = "Can't possible create session", int $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
