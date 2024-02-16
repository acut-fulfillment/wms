<?php

namespace AcutFulfillment\Wms;

use AcutFulfillment\Wms\Entities\Items;
use AcutFulfillment\Wms\Entities\Orders;
use AcutFulfillment\Wms\Entities\Returns;
use AcutFulfillment\Wms\Entities\Shipments;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;

class Request
{
    use Orders,
        Items,
        Returns,
        Shipments;

    public Client $client;

    public array $urls = [
        'production' => 'https://api.wms.acut-services.de',
        'sandbox' => '',
        'local' => 'http://api.wms.acut.local:8000'
    ];
    public string $version = 'v1';
    public string $environment = 'production';

    public array $headers = [];
    public array $auth = [];
    public array $queryParams = [];
    public array $formParams = [];

    public int $status;
    public array $response;
    public string $message;

    /**
     * @param  string  $apiKey
     * @param  string  $user
     * @param  string  $password
     */
    public function __construct(string $apiKey, string $user, string $password)
    {
        $this->headers = [
            'X-ACUT-API-KEY' => $apiKey
        ];

        $this->auth = [$user, $password];

        $this->client = new Client();
    }

    /**
     * Handles the request
     *
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function handleRequest(
        string $type,
        string $entity,
        array $queryParams = [],
        array $formParams = []
    ): static {
        try {
            $this->queryParams = $queryParams;
            $this->formParams = $formParams;

            $res = $this->client->request(strtoupper($type),
                "{$this->urls[$this->environment]}/{$this->version}/{$entity}",
                [
                    'headers' => $this->headers,
                    'auth' => $this->auth,
                    'query' => empty($this->queryParams) ? null : $this->queryParams,
                    'form_params' => empty($this->formParams) ? null : $this->formParams
                ]);

        } catch (ClientException $e) {
            $res = $e->getResponse();
        }

        $this->status = $res->getStatusCode();
        $this->response = json_decode($res->getBody(), true, 512, JSON_THROW_ON_ERROR);
        $this->message = $this->response['message'] ?? '';

        return $this;
    }

    /**
     * Sets the API-Version
     *
     * @param  string  $version
     * @return void
     */
    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

    /**
     * Sets the environment (production, sandbox or local)
     *
     * @param  string  $environment
     * @return void
     */
    public function setEnvironment(string $environment): void
    {
        $this->environment = $environment;
    }

    /**
     * Gets the statucodes of the last request
     *
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * Gets the response-body of the last request
     *
     * @return array
     */
    public function getResponse(): array
    {
        return $this->response;
    }

    /**
     * Gets the message in case of an error for the last request
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Checks if the last request failed (status !== 200)
     *
     * @return bool
     */
    public function failed(): bool
    {
        return $this->getStatus() !== 200;
    }
}