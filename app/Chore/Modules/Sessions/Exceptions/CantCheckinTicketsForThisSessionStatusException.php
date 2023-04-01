<?php

namespace App\Chore\Modules\Sessions\Exceptions;

use Exception;
use Throwable;

class CantCheckinTicketsForThisSessionStatusException extends Exception
{
    public function __construct(string $message = "Can't checkin tickets for this session status", int $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
