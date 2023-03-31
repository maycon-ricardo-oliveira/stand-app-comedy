<?php

namespace Tests\Unit;

use App\Chore\Exceptions\AttractionNotFoundException;
use App\Chore\Exceptions\InvalidAttractionStatusException;
use App\Chore\Exceptions\InvalidAttractionStatusTransitionException;
use App\Chore\Modules\Adapters\DateTimeAdapter\DateTimeAdapter;
use App\Chore\Modules\Adapters\DateTimeAdapter\IDateTime;
use App\Chore\Modules\Adapters\HashAdapter\HashAdapter;
use App\Chore\Modules\Adapters\UuidAdapter\UniqIdAdapter;
use App\Chore\Modules\Attractions\Entities\Attraction;
use App\Chore\Modules\Attractions\Entities\AttractionRepository;
use App\Chore\Modules\Attractions\Infra\Memory\AttractionRepositoryMemory;
use App\Chore\Modules\Attractions\UseCases\RegisterAttraction\RegisterAttraction;
use App\Chore\Modules\Attractions\UseCases\UpdateAttractionStatus\UpdateAttractionStatus;
use App\Chore\Modules\Comedians\Infra\Memory\ComedianRepositoryMemory;
use App\Chore\Modules\Places\Infra\Memory\PlaceRepositoryMemory;
use App\Chore\Modules\User\Infra\Memory\UserRepositoryMemory;
use Exception;

class UpdateAttractionStatusTest extends UnitTestCase
{

    private PlaceRepositoryMemory $placeRepo;
    private AttractionRepositoryMemory $attractionRepo;
    private UserRepositoryMemory $userRepo;
    private ComedianRepositoryMemory $comedianRepo;
    private UniqIdAdapter $uuid;
    private IDateTime $date;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->date = new DateTimeAdapter();
        $hash = new HashAdapter();

        $this->attractionRepo = new AttractionRepositoryMemory($this->date);
        $this->userRepo = new UserRepositoryMemory($this->date, $hash);
        $this->placeRepo = new PlaceRepositoryMemory();
        $this->comedianRepo = new ComedianRepositoryMemory();
        $this->uuid = new UniqIdAdapter();
    }

    /**
     * @throws InvalidAttractionStatusTransitionException
     * @throws AttractionNotFoundException
     * @throws InvalidAttractionStatusException
     * @throws Exception
     */
    public function testHandleDraftToPublished()
    {
        $status = 'published';

        $attractionMockData = [
            "title" => "any_title",
            "date" => "2023-01-09 00:00:00",
            "status" => "draft",
            "comedianId" => "any_id_1",
            "duration" => '180',
            "placeId" => "any_id",
            "ownerId" => "any_id_3",
        ];

        $attraction = $this->mockAttraction($attractionMockData);

        $useCase = new UpdateAttractionStatus($this->attractionRepo);
        $result = $useCase->handle($attraction->id, $status);

        $this->assertInstanceOf(Attraction::class, $result);
        $this->assertEquals($result->status, $status);
    }

    /**
     * @throws InvalidAttractionStatusTransitionException
     * @throws AttractionNotFoundException|InvalidAttractionStatusException
     * @throws Exception
     */
    public function testHandlePublishedToDraft()
    {
        $status = 'draft';

        $attractionMockData = [
            "title" => "any_title",
            "date" => "2023-01-09 00:00:00",
            "status" => "published",
            "comedianId" => "any_id_1",
            "duration" => '180',
            "placeId" => "any_id",
            "ownerId" => "any_id_3",
        ];

        $attraction = $this->mockAttraction($attractionMockData);
        $useCase = new UpdateAttractionStatus($this->attractionRepo);

        $result = $useCase->handle($attraction->id, $status);
        $this->assertEquals($result->status, $status);
        $this->assertInstanceOf(Attraction::class, $result);
    }

    public function testHandlePublishedToFinish()
    {
        $status = 'finish';

        $attractionMockData = [
            "title" => "any_title",
            "date" => "2023-01-09 00:00:00",
            "status" => "published",
            "comedianId" => "any_id_1",
            "duration" => '180',
            "placeId" => "any_id",
            "ownerId" => "any_id_3",
        ];

        $attraction = $this->mockAttraction($attractionMockData);
        $useCase = new UpdateAttractionStatus($this->attractionRepo);

        $result = $useCase->handle($attraction->id, $status);
        $this->assertEquals($result->status, $status);
        $this->assertInstanceOf(Attraction::class, $result);
    }

    public function testHandleDraftToFinish()
    {
        $status = 'finish';

        $attractionMockData = [
            "title" => "any_title",
            "date" => "2023-01-09 00:00:00",
            "status" => "draft",
            "comedianId" => "any_id_1",
            "duration" => '180',
            "placeId" => "any_id",
            "ownerId" => "any_id_3",
        ];

        $attraction = $this->mockAttraction($attractionMockData);
        $useCase = new UpdateAttractionStatus($this->attractionRepo);

        $this->expectException(InvalidAttractionStatusTransitionException::class);
        $useCase->handle($attraction->id, $status);
    }

    public function testCanPublishAttraction()
    {
        $status = 'published';

        $attractionMockData = [
            "title" => "any_title",
            "date" => "2023-01-09 00:00:00",
            "status" => "draft",
            "comedianId" => "any_id_1",
            "duration" => '180',
            "placeId" => "any_id",
            "ownerId" => "any_id_3",
        ];

        $attraction = $this->mockAttraction($attractionMockData);
        $useCase = new UpdateAttractionStatus($this->attractionRepo);

        $this->expectException(InvalidAttractionStatusTransitionException::class);
        $useCase->handle($attraction->id, $status);
    }

/*


    public function testCannotPublishAttractionWhenAlreadyPublished()
    {
        $attractionId = "abc123";
        $status = "published";
        $attractionData = [
            "id" => $attractionId,
            "title" => "Test Attraction",
            "date" => "2022-04-15",
            "duration" => "120",
            "comedian" => new Comedian("John Doe"),
            "timeToEvent" => "2 hours",
            "place" => new Place("Test Venue"),
            "status" => "published",
            "owner" => "ownerId"
        ];

        $attraction = Attraction::fromArray($attractionData);

        $this->attractionRepository->expects($this->once())
            ->method('findAttractionById')
            ->with($attractionId)
            ->willReturn($attraction);

        $this->expectException(AttractionStatusException::class);

        $this->attractionPublish->handle($attractionId, $status);
    }

*/
    /**
     * @throws Exception
     */
    public function mockAttraction($attractionData): Attraction
    {
        $useCase = new RegisterAttraction(
            $this->attractionRepo,
            $this->comedianRepo,
            $this->placeRepo,
            $this->userRepo,
            $this->uuid
        );

        return $useCase->handle($attractionData, $this->date);

    }
}
