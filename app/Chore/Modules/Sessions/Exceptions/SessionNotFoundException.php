<?php

namespace App\Chore\Modules\Session\Exceptions;

use Throwable;

class SessionNotFoundException extends \Exception {
    public function __construct(string $message = 'Session not found', int $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
