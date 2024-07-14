<?php

namespace App\Http\Controllers;

use App\Chore\Modules\Adapters\UuidAdapter\UniqIdAdapter;
use App\Chore\Modules\Attractions\Infra\MySql\AttractionDAODatabase;
use App\Chore\Modules\Comedians\Infra\MySql\ComedianDAODatabase;
use App\Chore\Modules\HotContent\Entities\ContentType;
use App\Chore\Modules\HotContent\Exceptions\InvalidContentTypeException;
use App\Chore\Modules\HotContent\Infra\HotContentsRepository;
use App\Chore\Modules\HotContent\UseCases\GetHotContentByType;
use App\Chore\Modules\HotContent\UseCases\SaveHotContent;
use App\Chore\Modules\Places\Infra\MySql\PlaceDAODatabase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class HotContentController extends Controller
{

    private AttractionDAODatabase $attractionsRepo;
    private ComedianDAODatabase $comediansRepo;
    private HotContentsRepository $hotContentRepo;
    private UniqIdAdapter $uuid;
    private PlaceDAODatabase $placesRepo;
    private SaveHotContent $saveHotContent;
    private GetHotContentByType $getHotContentByType;

    public function __construct()
    {
        parent::__construct();

        $this->attractionsRepo = new AttractionDAODatabase($this->dbConnection, $this->time);
        $this->comediansRepo = new ComedianDAODatabase($this->dbConnection, $this->time);
        $this->hotContentRepo = new HotContentsRepository($this->time);
        $this->placesRepo = new PlaceDAODatabase($this->dbConnection, $this->time);
        $this->uuid = new UniqIdAdapter();

        $this->saveHotContent = new SaveHotContent(
            $this->attractionsRepo,
            $this->comediansRepo,
            $this->hotContentRepo,
            $this->placesRepo,
            $this->uuid
        );

        $this->getHotContentByType = new GetHotContentByType(
            $this->attractionsRepo,
            $this->comediansRepo,
            $this->hotContentRepo,
            $this->placesRepo,
        );

    }

    public function saveHotContent(Request $request): JsonResponse
    {
        try {
            $this->validate($request, [
                'contentType' => 'required|string',
                'contentId' => 'required|string',
            ]);

            $contentType = new ContentType($request->contentType);
            $contentId = $request->contentId;
            $response = $this->saveHotContent->handle($contentType, $contentId);
            return $this->response->successResponse($response);

        } catch(Exception $exception) {
            return $this->response->badRequestResponse($exception->getMessage());
        }
    }

    public function getHotContentByType(Request $request): JsonResponse
    {
        try {
            $contentType = new ContentType($request->contentType);
            $response = $this->getHotContentByType->handle($contentType);
            return $this->response->successResponse($response);
        } catch(Exception $exception) {
            return $this->response->badRequestResponse($exception->getMessage());
        }
    }

}
