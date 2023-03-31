<?php

namespace App\Chore\Modules\Adapters\HashAdapter;

class HashAdapter implements IHash
{

    public function make($value, $options = [])
    {
        return bcrypt($value, $options);
    }
}
