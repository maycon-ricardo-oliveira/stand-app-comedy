<?php

namespace App\Chore\Modules\Pathfinder\Entities;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class SymplaGateway extends Pathfinder implements AttractionFinderGateway
{
    const PATH = "https://www.sympla.com.br/eventos/stand-up-comedy/todos-eventos";

    private HttpClient $httpClient;

    /**
     * @param HttpClient $httpClient
     */
    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    private function path($page = 1): string
    {
        return self::PATH ."?page=$page";
    }

    public function getAttractions($page = 1)
    {
        $response = $this->httpClient->get($this->path($page));

        $html = (string)$response->getBody();
        $crawler = new Crawler($html);

        $attractions = [];

        $cards = $crawler->filter('div[class^="CustomGridstyle__CustomGridContainer"]');

        foreach ($cards as $card) {
            $item = new Crawler($card);

            $location = $item->filter('div[class^="EventCardstyle__EventLocation"]')->text();
            $title = $item->filter('h3[class^="EventCardstyle__EventTitle"]')->text();
            $image = $item->filter('div[class^="EventCardstyle__ImageContainer"] img')->attr('src');

            $attractions[] = new AttractionsOutput($title, $location, $image, '', '', '');

            echo " $location \n";
        }

        return $attractions;

    }

    public function getComedian()
    {
        // TODO: Implement getComedian() method.
    }

    public function getPlace()
    {
        // TODO: Implement getPlace() method.
    }
}
