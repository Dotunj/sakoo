<?php

namespace App\Services;

use GuzzleHttp\Client;

class Drift
{
    protected $clientId;

    protected $clientSecret;

    protected $baseUrl;

    public function __construct()
    {
        $this->clientId = config('services.drift.client_id');

        $this->clientSecret = config('services.drift.client_secret');

        $this->baseUrl = config('services.drift.base_url');

        //$this->setupClient();
    }

    protected function setupClient()
    { 

        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);
    }

    public function fetchAccessToken($code)
    {
        $guzzle = new Client();

        $response = $guzzle->request('POST', $this->baseUrl . '/oauth2/token', [
            'form_params' => [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'code' => $code,
                'grant_type' => 'authorization_code'
            ]
        ]);

        $body = $response->getBody();

        $result = json_decode($body, true);

        return $result;
    }
}
