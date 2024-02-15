<?php

namespace AcutFulfillment\Wms;

use AcutFulfillment\Wms\Entities\Orders;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;

class Wms
{
    use Orders;

    public array $requestParams = [];
    public string $version = 'v1';
    public string $environment = 'production';
    public array $urls = [
        'production' => 'https://api.wms.acut-services.de',
        'sandbox' => '',
        'local' => 'http://api.wms.acut.local:8000'
    ];
    public Client $client;

    /**
     * @param  string  $apiKey
     * @param  string  $user
     * @param  string  $password
     */
    public function __construct(string $apiKey, string $user, string $password)
    {
        $this->requestParams = [
            'headers' => [
                'X-ACUT-API-KEY' => $apiKey
            ],
            'auth' => [$user, $password]
        ];

        $this->client = new Client();
    }

    /**
     * @param  string  $version
     * @return void
     */
    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

    public function setEnvironment(string $environment): void
    {
        $this->environment = $environment;
    }

    /**
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function handleRequest(
        string $type,
        string $entity,
        array $queryParams = [],
        array $body = []
    ) {
        try {
            $res = $this->client->request(strtoupper($type), "{$this->urls[$this->environment]}/{$this->version}/{$entity}",
                $this->requestParams);
        } catch (ClientException $e) {
            $res = $e->getResponse();
            json_decode($res->getBody(), true, 512, JSON_THROW_ON_ERROR);
        }

        return json_decode($res->getBody(), true, 512, JSON_THROW_ON_ERROR);
    }
}