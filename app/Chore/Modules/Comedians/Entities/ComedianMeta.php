<?php

namespace App\Chore\Modules\Comedians\Entities;

use App\Chore\Modules\Comedians\Exceptions\InvalidComedianMetaException;

class ComedianMeta
{
    public string $id;
    public string $comedianId;
    public string $name;
    public string $value;

    const TAG = 'tag';
    const ON_FIRE = 'onFire';
    const CONTACT = 'contact';
    const EMAIL = 'email';

    /**
     * @param string $id
     * @param string $comedianId
     * @param string $name
     * @param string $value
     * @throws InvalidComedianMetaException
     */
    public function __construct(string $id, string $comedianId, string $name, string $value)
    {

        $this->id = $id;
        $this->comedianId = $comedianId;
        $this->name = $name;
        $this->value = $value;

        $this->validate();
    }

    private function validateAvailableMetas(): bool
    {
        return in_array($this->name, [
            self::ON_FIRE,
            self::CONTACT,
            self::EMAIL,
            self::TAG
        ]);
    }

    /**
     * @throws InvalidComedianMetaException
     */
    private function validate(): void
    {
        if (!$this->validateAvailableMetas()) {
            throw new InvalidComedianMetaException();
        }
    }
}
