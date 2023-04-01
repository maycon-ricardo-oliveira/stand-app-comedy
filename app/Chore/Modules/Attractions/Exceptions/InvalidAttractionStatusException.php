<?php

namespace App\Chore\Modules\Attractions\Exceptions;

use Throwable;

class InvalidAttractionStatusException extends \Exception
{
    public function __construct(string $message = 'Invalid attraction status', int $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }

}
