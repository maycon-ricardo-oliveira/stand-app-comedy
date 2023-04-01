<?php

namespace App\Chore\Modules\Sessions\Exceptions;

use Exception;
use Throwable;

class CantEmitTicketsForThisSessionStatusException extends Exception
{
    public function __construct(string $message = "Can't emit tickets for this session status", int $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
