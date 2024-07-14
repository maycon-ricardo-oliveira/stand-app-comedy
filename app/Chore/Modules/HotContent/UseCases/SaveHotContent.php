<?php

namespace App\Chore\Modules\HotContent\UseCases;

use App\Chore\Modules\Adapters\UuidAdapter\IUniqId;
use App\Chore\Modules\Attractions\Entities\AttractionRepository;
use App\Chore\Modules\Comedians\Entities\ComedianRepository;
use App\Chore\Modules\HotContent\Entities\ContentType;
use App\Chore\Modules\HotContent\Entities\HotContent;
use App\Chore\Modules\HotContent\Entities\HotContentRepository;
use App\Chore\Modules\Places\Entities\PlaceRepository;

class SaveHotContent
{
    private AttractionRepository $attractionRepo;
    private ComedianRepository $comedianRepo;
    private HotContentRepository $hotContentRepo;
    private PlaceRepository $placeRepo;
    private IUniqId $uuid;

    /**
     * @param AttractionRepository $attractionRepo
     * @param ComedianRepository $comedianRepo
     * @param HotContentRepository $hotContentRepo
     * @param PlaceRepository $placeRepo
     * @param IUniqId $uuid
     */
    public function __construct(AttractionRepository $attractionRepo, ComedianRepository $comedianRepo, HotContentRepository $hotContentRepo, \App\Chore\Modules\Places\Entities\PlaceRepository $placeRepo, \App\Chore\Modules\Adapters\UuidAdapter\IUniqId $uuid)
    {
        $this->attractionRepo = $attractionRepo;
        $this->comedianRepo = $comedianRepo;
        $this->hotContentRepo = $hotContentRepo;
        $this->placeRepo = $placeRepo;
        $this->uuid = $uuid;
    }

    public function handle(ContentType $contentType, string $contentId): bool
    {
        switch ($contentType->type) {
            case ContentType::HOT_ATTRACTIONS:
                $content = $this->attractionRepo->findAttractionById($contentId);
                return $this->registerHotContent($content, $contentType);
        case ContentType::HOT_COMEDIANS:
            $content = $this->comedianRepo->getComedianById($contentId);
            return $this->registerHotContent($content, $contentType);
        case ContentType::HOT_PLACES:
            $content = $this->placeRepo->getPlaceById($contentId);
            return $this->registerHotContent($content, $contentType);
        }
        return false;
    }

    private function registerHotContent($content, $contentType)
    {
        $hotContent = new HotContent(
            $this->uuid->id(),
            $content->id,
            $contentType,
        );
        return $this->hotContentRepo->saveHotContent($hotContent);
    }

}
