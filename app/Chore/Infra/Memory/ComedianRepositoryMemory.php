<?php

namespace App\Chore\Infra\Memory;

use App\Chore\Domain\Comedian;
use App\Chore\Domain\ComedianRepository;
use App\Chore\Domain\IDateTime;
use App\Chore\Domain\IUniqId;
use App\Chore\Domain\User;
use App\Chore\Infra\ComedianMapper;

class ComedianRepositoryMemory extends ComedianMapper implements ComedianRepository
{
    /**
     * @var Comedian[]
     */
    private array $comedians;
    private IDateTime $time;

    /**
     * @param array $comedians
     * @throws \Exception
     */
    public function __construct(IDateTime $time, array $comedians = [])
    {

        $this->time = $time;
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

    public function getComedianById(string $id)
    {
        $response = array_filter($this->comedians, function ($comedian) use ($id) {
            return $comedian->id == $id;
        });
        return $response;
    }

    /**
     * @param array $comedians
     * @return void
     * @throws \Exception
     */
    private function generateComedians(array $comedians = []): void
    {
        if (empty($comedians)) $comedians = $this->dataSet();
        $this->comedians = $this->mapper($this->time, $comedians);
    }

    public function followComedian(User $user, Comedian $comedian)
    {
        // TODO: Implement followComedian() method.
    }
}
