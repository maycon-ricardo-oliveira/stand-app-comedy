<?php

namespace App\Chore\Modules\Places\Exceptions;

use Exception;
use Throwable;

class PlaceAlreadyRegisteredException extends Exception {
    public function __construct(string $message = 'Place already registered', int $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, );
    }
}
