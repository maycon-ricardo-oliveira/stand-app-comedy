<?php

namespace App\Chore\Domain;

use DateTimeImmutable;

class SessionCode
{
    private string $code;
    public function __construct(string $code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    public static function fromCode(string $code): SessionCode
    {
        return new SessionCode($code);
    }
    public static function generate(string $string, DateTimeImmutable $time): SessionCode
    {

        $words = explode(" ", $string);
        $code = '';
        foreach ($words as $word) {
            $char = preg_replace('/[^A-Za-z0-9]/', '', substr($word, 0, 1));
            $code .= strtoupper($char);
        }

        $code .= '-' . $time->format('ymd-hi');
        return new SessionCode($code);
    }
    public function toString(): string {
        return $this->code;
    }
}
