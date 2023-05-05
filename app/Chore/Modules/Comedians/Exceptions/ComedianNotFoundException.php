<?php

namespace App\Chore\Modules\Comedians\Exceptions;

use Throwable;

class ComedianNotFoundException extends \Exception {
    public function __construct(string $message = 'Comedian not found ComedianAlreadyRegistered ', int $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

