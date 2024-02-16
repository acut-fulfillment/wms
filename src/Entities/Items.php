<?php

namespace AcutFulfillment\Wms\Entities;

use AcutFulfillment\Wms\Request;
use AcutFulfillment\Wms\Wms;
use GuzzleHttp\Exception\GuzzleException;

trait Items
{
    /**
     * @param  array  $params
     * @return Request
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function getItems(array $params = []): Request
    {
        return $this->handleRequest('get', "items", $params);
    }

    /**
     * @param  int  $id
     * @return Request
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function getItemById(int $id): Request
    {
        return $this->handleRequest('get', "items/{$id}");
    }

    /**
     * @param  string  $barcode
     * @return Request
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function getItemByBarcode(string $barcode): Request
    {
        return $this->handleRequest('get', "items/barcode/{$barcode}");
    }
}