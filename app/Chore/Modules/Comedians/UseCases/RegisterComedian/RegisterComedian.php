<?php

namespace App\Chore\Modules\Comedians\UseCases\RegisterComedian;

use App\Chore\Modules\Adapters\HashAdapter\IHash;
use App\Chore\Modules\Adapters\UuidAdapter\IUniqId;
use App\Chore\Modules\Comedians\Entities\Comedian;
use App\Chore\Modules\Comedians\Entities\ComedianRepository;
use App\Chore\Modules\Comedians\Exceptions\ComedianAlreadyRegistered;
use Exception;

class RegisterComedian
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
    public function handle($comedianData ): ?Comedian
    {
        $comedian = $this->comedianRepository->getComedianByName($comedianData['name']);

        if ($comedian instanceof Comedian) throw new ComedianAlreadyRegistered();

        $comedian = new Comedian(
            $this->uuid->id(),
            $comedianData["name"],
            $comedianData["miniBio"],
            $comedianData["thumbnail"],
            $item['imageMain'] ?? '',
            $comedianData['onFire'] ?? false,
            $comedianData["metas"] ?? [],
            $comedianData["socialMedias"] ?? [],
            $comedianData["attractions"]
        );

        $this->comedianRepository->register($comedian);
        return $this->comedianRepository->getComedianById($comedian->id);
    }

}
