<?php

namespace App\Services;

use GuzzleHttp\Client;

class Drift
{
    protected $clientId;

    protected $secret;

    protected $baseUrl;

    public function __construct()
    {
        $this->clientId = config('services.drift.client_id');

        $this->secret = config('services.drift.client_secret');

        $this->baseUrl = config('services.drift.base_url');

        $this->setupClient();
    }

    protected function setupClient()
    { 
        $bearer = 'Bearer ' . $this->secret;

        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Authorization' => $bearer,
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Accept' => 'application/json',
            ],
        ]);
    }

    public function fetchAccessToken($code)
    {
        $response = $this->client->request('POST', '/oauth2/token', [
            'application/x-www-form-urlencoded' => [
                'code' => $code,
                'grant_type' => 'authorization_code'
            ]
        ]);

        $body = $response->getBody();

        $result = json_decode($body, true);

        return $result;
    }
}
