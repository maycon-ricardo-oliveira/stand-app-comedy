<?php

namespace App\Chore\Modules\User;

use Exception;
use Throwable;

class UserAlreadyRegisteredException extends Exception {
    public function __construct(string $message = 'This user already registered', int $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
