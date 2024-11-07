<?php
declare(strict_types=1);

namespace Dzinekk\ClaidAI;

use GuzzleHttp\Exception\GuzzleException;

class Client {
    protected \GuzzleHttp\Client $client;
    
    /**
     * @param string $apiKey
     * @param array<string, mixed> $options
     */
    public function __construct(
        private readonly string $apiKey,
        private readonly array $options = [],
    ) {
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => 'https://api.claid.ai/v1-beta1/',
            'headers' => [
                'Host' => 'api.claid.ai',
                'Authorization' => 'Bearer '.$this->apiKey,
                'Content-Type' => 'application/json',
            ]
        ] + $this->options);
    }
    
    /**
     * @param string $method
     * @param string $uri
     * @param array<string, mixed>|null $data
     * @param array<string, mixed>|null $query
     * @return array<string, mixed>
     * @throws ClaidException
     */
    public function request(string $method, string $uri, array $data = null, array $query = null): array {
        if (!empty($data)) {
            $body = json_encode($data);

            if (!$body) {
                throw new ClaidException('Failed encoding JSON request.');
            }
        }

        $options = [];
        
        if (!empty($query)) {
            $options['query'] = $query;
        }

        if (!empty($data)) {
            $options['json'] = $data;
        }
        
        try {
            $response = $this->client->request($method, $uri, $options);
        } catch (GuzzleException $e) {
            throw new ClaidException('Failed making request: '.$e->getMessage());
        }
        
        if ($response->getBody()->getSize() === 0) {
            return [];
        }

        /**
         * @var array<string, mixed>|null $data
         */
        $data = json_decode($response->getBody()->getContents(), true);

        if ($data === null) {
            throw new ClaidException('Failed parsing JSON response.');
        }

        return $data;
    }
    
    public function editImage(
        string $input
    ): ImageEdit {
        return new ImageEdit($this, $input);
    }
}