<?php

namespace App\Chore\Modules\Comedians\Infra\Memory;

use App\Chore\Modules\Adapters\DateTimeAdapter\IDateTime;
use App\Chore\Modules\Comedians\Entities\Comedian;
use App\Chore\Modules\Comedians\Entities\ComedianMeta;
use App\Chore\Modules\Comedians\Entities\ComedianRepository;
use App\Chore\Modules\Comedians\Infra\ComedianMapper;

class ComedianRepositoryMemory extends ComedianMapper implements ComedianRepository
{
    /**
     * @var Comedian[]
     */
    private array $comedians;

    /**
     * @param array $comedians
     * @throws \Exception
     */
    public function __construct(array $comedians = [])
    {
        parent::__construct();
        $this->generateComedians($comedians);
    }
    public function dataSet() {
        return [[
            "id" => 'any_id_1',
            "name" => 'any_name',
            "miniBio" => 'any_miniBio',
            "socialMedias" => [
                'mediaName' => 'instagram',
                'profile' => '@any_id'
            ],
        ], [
            "id" => 'any_id_2',
            "name" => 'any_name',
            "miniBio" => 'any_miniBio',
            "socialMedias" => [
                'mediaName' => 'instagram',
                'profile' => '@any_id'
            ],
        ]];
    }

    public function getComedianById(string $id): ?Comedian
    {
        $response = array_values(array_filter($this->comedians, function ($comedian) use ($id) {
            return $comedian->id == $id;
        }));
        return count($response) == 0 ? null : $response[0];
    }

    /**
     * @param array $comedians
     * @return void
     * @throws \Exception
     */
    private function generateComedians(array $comedians = []): void
    {
        if (empty($comedians)) $comedians = $this->dataSet();
        $this->comedians = $this->mapper($comedians);
    }

    public function getListOfComedians(array $comedianIds)
    {
        if (empty($comedians)) $comedians = $this->dataSet();
        $this->comedians = $this->mapper($comedians);
    }

    public function register(Comedian $comedian): bool
    {
        $this->comedians[] = $comedian;
        return true;
    }

    public function getComedianByName(string $name): ?Comedian
    {
        $response = array_values(array_filter($this->comedians, function ($comedian) use ($name) {
            return $comedian->name == $name;
        }));

        return count($response) == 0 ? null : $response[0];
    }

    public function registerMeta(ComedianMeta $comedianMeta)
    {
        // TODO: Implement registerMeta() method.
    }

    public function getComedianMetas(string $id): array
    {
        // TODO: Implement getComedianMetas() method.
    }

    public function getAllComedians()
    {
        // TODO: Implement getAllComedians() method.
    }
}
