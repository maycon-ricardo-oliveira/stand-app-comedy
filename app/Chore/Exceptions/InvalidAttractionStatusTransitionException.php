<?php

namespace App\Chore\Exceptions;

use Throwable;

class InvalidAttractionStatusTransitionException extends \Exception
{
    public function __construct(string $message = 'Invalid attraction status transition', int $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }

}
