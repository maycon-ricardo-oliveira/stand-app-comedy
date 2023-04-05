<?php

namespace App\Chore\Modules\Pathfinder\Entities;


class SampaIngressosGateway extends Pathfinder implements AttractionFinderGateway
{
    const PATH = 'https://www.sampaingressos.com.br/espetaculos/standUp';
    private HttpClient $httpClient;

    /**
     * @param HttpClient $httpClient
     */
    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    private function path($page = 1, $idPartner = ''): string
    {
        return self::PATH ."&$page?idPartner=".$idPartner;
    }

    public function getAttractions($page = 1): array
    {

        $response = $this->httpClient->post($this->path($page));

        $html = json_decode($response->getBody());
        $returnHtml = json_decode($html->retorno);
        $return = json_decode($returnHtml->espetaculo);

        $response = [];

        foreach ($return->espetaculos as $attraction) {
            $response[] = new AttractionsOutput(
                $attraction->nome,
                $attraction->local,
                $attraction->imagem,
                $attraction->temporada,
                $attraction->horario,
                $attraction->urlPaginaSampaIngressos,
            );
        }

        return $response;
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

