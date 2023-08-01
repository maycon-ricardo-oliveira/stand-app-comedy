<?php

namespace App\Chore\Modules\Comedians\UseCases\RegisterComedianMeta;

use App\Chore\Modules\Adapters\HashAdapter\IHash;
use App\Chore\Modules\Adapters\UuidAdapter\IUniqId;
use App\Chore\Modules\Comedians\Entities\Comedian;
use App\Chore\Modules\Comedians\Entities\ComedianMeta;
use App\Chore\Modules\Comedians\Entities\ComedianRepository;
use App\Chore\Modules\Comedians\Exceptions\ComedianNotFoundException;
use Exception;

class RegisterComedianMeta
{

    public ComedianRepository $comedianRepository;

    public IHash $bcrypt;
    public IUniqId $uuid;
    public function __construct(ComedianRepository $comedianRepository, IUniqId $uuid)
    {
        $this->comedianRepository = $comedianRepository;
        $this->uuid = $uuid;
    }

    /**
     * @throws Exception
     */
    public function handle($comedianMetaData): ?Comedian
    {
        $comedian = $this->comedianRepository->getComedianById($comedianMetaData['comedianId']);

        if (!$comedian instanceof Comedian) throw new ComedianNotFoundException();

        $comedianMeta = new ComedianMeta(
            $this->uuid->id(),
            $comedian->id,
            $comedianMetaData['name'],
            $comedianMetaData['value']
        );

        $this->comedianRepository->registerMeta($comedianMeta);
        return $this->comedianRepository->getComedianById($comedian->id);
    }

}
