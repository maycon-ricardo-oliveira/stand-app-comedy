<?php

namespace App\Chore\Adapters;

use App\Chore\Domain\IHash;
use Illuminate\Hashing\BcryptHasher;

class HashAdapter implements IHash
{

    public function make($value, $options = [])
    {
        return bcrypt($value, $options);
    }
}
