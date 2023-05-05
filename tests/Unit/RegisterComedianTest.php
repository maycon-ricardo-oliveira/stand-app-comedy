<?php

namespace Tests\Unit;

use App\Chore\Modules\Adapters\DateTimeAdapter\DateTimeAdapter;
use App\Chore\Modules\Adapters\UuidAdapter\UniqIdAdapter;
use App\Chore\Modules\Comedians\Entities\ComedianRepository;
use App\Chore\Modules\Comedians\Exceptions\ComedianAlreadyRegistered;
use App\Chore\Modules\Comedians\Infra\Memory\ComedianRepositoryMemory;
use App\Chore\Modules\Comedians\UseCases\RegisterComedian\RegisterComedian;
use App\Oneclick\Exceptions\InvalidTokenException;
use Exception;

class RegisterComedianTest extends UnitTestCase
{
    private ComedianRepository $comedianRepository;
    private UniqIdAdapter $uuid;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->date = new DateTimeAdapter();
        $this->uuid = new UniqIdAdapter();
        $this->comedianRepository = new ComedianRepositoryMemory();
    }

    /**
     * @throws Exception
     */
    public function testMustRegisterComedian()
    {
        $useCase = new RegisterComedian(
            $this->comedianRepository,
            $this->uuid,
        );

        $comedianData = [
            'name' => 'Comedian',
            'miniBio' => 'miniBio',
            'thumbnail' => 'thumbnail',
            'attractions' => []
        ];

        $result = $useCase->handle($comedianData);

        $this->assertSame($comedianData['name'], $result->name);
        $this->assertSame($comedianData['miniBio'], $result->miniBio);
        $this->assertSame($comedianData['thumbnail'], $result->thumbnail);

    }

    /**
     * @throws Exception
     */
    public function testMustReturnExceptionToRegisterComedian()
    {
        $this->expectException(ComedianAlreadyRegistered::class);

        $useCase = new RegisterComedian(
            $this->comedianRepository,
            $this->uuid,
        );

        $comedianData = [
            'name' => 'Comedian',
            'miniBio' => 'miniBio',
            'thumbnail' => 'thumbnail',
            'attractions' => []
        ];

        $useCase->handle($comedianData);
        $useCase->handle($comedianData);
    }

}
