<?php

namespace App\Chore\Modules\User\Exceptions;

use Throwable;

class UserNotFoundException extends \Exception {
    public function __construct(string $message = 'User not found', int $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
