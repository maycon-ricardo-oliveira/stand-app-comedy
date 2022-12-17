<?php

namespace App\Chore\Infra;

use App\Chore\Domain\Audiobook;
use App\Models\Attraction;
use ArrayIterator;
use Illuminate\Database\Eloquent\Collection;

class AttractionDTO extends ArrayIterator {

    public array $audiobooks;

    /**
     * @param array|Collection $audiobooks
     * @throws \Exception
     */
    public function __construct(array|Collection $audiobooks)
    {

        parent::__construct();


        foreach ($audiobooks as $audiobook) {
            if (!$audiobook instanceof Attraction) {
                throw new Exception("Audiobook not found");
            }

            $item = new Audiobook(
                $audiobook->id,
                $audiobook->title,
                $audiobook->description,
                $audiobook->publisher,
                $audiobook->isbn,
                $audiobook->thumbnail,
                $audiobook->duration,
                $audiobook->fileSourceUrl,
                $audiobook->invoiceReference,
                $audiobook->status,
                $audiobook->language,
                $audiobook->available,
                $audiobook->created_at,
                $audiobook->updated_at
            );
            $this->audiobooks[] = $item;
        }
    }

}
