<?php

namespace App\Services;

use GuzzleHttp\Client;

class RecommendationService
{
    protected $client;
    
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://localhost:8000/', // Update this if using a remote server
        ]);
    }

    public function getRecommendations($userId, $topN = 5)
    {
        $response = $this->client->get("recommend/{$userId}?top_n={$topN}");
        return json_decode($response->getBody(), true);
    }
}
