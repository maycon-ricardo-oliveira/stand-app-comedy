<?php

namespace App\Chore\Modules\Tickets\Exceptions;

use Exception;
use Throwable;

class TicketNotFoundException extends Exception {
    public function __construct(string $message = 'Ticket not found', int $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

