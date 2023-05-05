<?php

namespace App\Chore\Modules\Comedians\Exceptions;

use Exception;
use Throwable;

class ComedianAlreadyRegistered extends Exception {
    public function __construct(string $message = 'Comedian already registered', int $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
