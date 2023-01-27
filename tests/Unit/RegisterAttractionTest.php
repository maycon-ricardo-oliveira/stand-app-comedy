<?php

namespace Tests\Unit;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Adapters\HashAdapter;
use App\Chore\Adapters\UniqIdAdapter;
use App\Chore\Infra\Memory\AttractionRepositoryMemory;
use App\Chore\Infra\Memory\ComedianRepositoryMemory;
use App\Chore\Infra\Memory\PlaceRepositoryMemory;
use App\Chore\Infra\Memory\UserRepositoryMemory;
use App\Chore\UseCases\ListAttractionsByLocation\ListAttractionsByLocation;
use App\Chore\UseCases\RegisterAttraction\RegisterAttraction;

class RegisterAttractionTest extends UnitTestCase
{
    public function testMustReturnAListOfAttractions()
    {
        $hash = new HashAdapter();
        $date = new DateTimeAdapter();
        $attractionRepo = new AttractionRepositoryMemory($date);
        $userRepo = new UserRepositoryMemory($date, $hash);
        $placeRepo = new PlaceRepositoryMemory();
        $comedianRepo = new ComedianRepositoryMemory();
        $uuid = new UniqIdAdapter();

        $useCase = new RegisterAttraction($attractionRepo, $comedianRepo, $placeRepo, $userRepo, $uuid);

        $attraction = [
            "title" => "any_title",
            "date" => "2023-01-09 00:00:00",
            "status" => "any_status",
            "comedianId" => "any_id_1",
            "duration" => '180',
            "placeId" => "any_id",
            "ownerId" => "any_id_3",
        ];

        $response = $useCase->handle($attraction, $date);

        $this->assertSame($response->title, $attraction["title"]);
    }
}
