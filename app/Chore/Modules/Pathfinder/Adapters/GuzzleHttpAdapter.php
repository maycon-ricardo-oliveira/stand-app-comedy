<?php

namespace App\Chore\Modules\Pathfinder\Adapters;

use App\Chore\Modules\Pathfinder\Entities\HttpClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Http\Client\RequestException;

class GuzzleHttpAdapter implements HttpClient
{

    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function get($url)
    {
        try {
            $response = $this->client->get($url);
            return $response;
        } catch (RequestException|ConnectException $e) {
            echo 'Erro ao fazer a solicitação: ' . $e->getMessage();
            exit();
        }
    }

    public function post($url)
    {
        try {
            $response = $this->client->post($url);
            return $response;
        } catch (RequestException|ConnectException $e) {
            echo 'Erro ao fazer a solicitação: ' . $e->getMessage();
            exit();
        }
    }
}
