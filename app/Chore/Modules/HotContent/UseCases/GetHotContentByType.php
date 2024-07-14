<?php

namespace App\Chore\Modules\HotContent\UseCases;

use App\Chore\Modules\Attractions\Entities\AttractionRepository;
use App\Chore\Modules\Comedians\Entities\ComedianRepository;
use App\Chore\Modules\HotContent\Entities\ContentType;
use App\Chore\Modules\HotContent\Entities\HotContentRepository;
use App\Chore\Modules\HotContent\Entities\HotContentScore;
use App\Chore\Modules\Places\Entities\PlaceRepository;

class GetHotContentByType
{
    private AttractionRepository $attractionRepo;
    private ComedianRepository $comedianRepo;
    private HotContentRepository $hotContentRepo;
    private PlaceRepository $placeRepo;

    /**
     * @param AttractionRepository $attractionRepo
     * @param ComedianRepository $comedianRepo
     * @param HotContentRepository $hotContentRepo
     * @param PlaceRepository $placeRepo
     */
    public function __construct(AttractionRepository $attractionRepo, ComedianRepository $comedianRepo, HotContentRepository $hotContentRepo, PlaceRepository $placeRepo)
    {
        $this->attractionRepo = $attractionRepo;
        $this->comedianRepo = $comedianRepo;
        $this->hotContentRepo = $hotContentRepo;
        $this->placeRepo = $placeRepo;
    }

    public function handle(ContentType $contentType)
    {
        $hotContents = $this->hotContentRepo->getHotContentByType($contentType);
        $response = [];

        foreach ($hotContents as $hotContent) {
            switch ($contentType->type) {
                case ContentType::HOT_ATTRACTIONS:
                    $content = $this->attractionRepo->findAttractionById($hotContent->content_id);
                    $response[] = new HotContentScore($hotContent->count, $contentType, $content);
                    break;
                case ContentType::HOT_COMEDIANS:
                    $content = $this->comedianRepo->getComedianById($hotContent->content_id);
                    $response[] = new HotContentScore($hotContent->count, $contentType, $content);
                    break;
                case ContentType::HOT_PLACES:
                    $content = $this->placeRepo->getPlaceById($hotContent->content_id);
                    $response[] = new HotContentScore($hotContent->count, $contentType, $content);
                    break;
            }
        }
        return $response;
    }

}
