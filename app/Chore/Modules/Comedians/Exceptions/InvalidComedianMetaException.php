<?php

namespace App\Chore\Modules\Comedians\Exceptions;

use Exception;
use Throwable;

class InvalidComedianMetaException extends Exception
{
    public function __construct(string $message = 'Is not a valid comedian meta', int $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }

}
