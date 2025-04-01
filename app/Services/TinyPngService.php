<?php

declare(strict_types=1);

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class TinyPngService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('TINYPNG_API_KEY');
    }

    public function compressImage($imagePath)
    {
        try {
            $response = $this->client->request('POST', 'https://api.tinypng.com/shrink', [
                'auth' => ['api', $this->apiKey],
                'headers' => [
                    'Content-Type' => 'application/octet-stream',
                ],
                'body' => fopen($imagePath, 'r'),
            ]);

            $body = json_decode($response->getBody()->getContents(), true);

            if (isset($body['output']['url'])) {
                return $body['output']['url'];
            }

            return null;
        } catch (RequestException $e) {
            return null;
        }
    }
}
