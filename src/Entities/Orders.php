<?php

namespace AcutFulfillment\Wms\Entities;

use AcutFulfillment\Wms\Request;
use GuzzleHttp\Exception\GuzzleException;

trait Orders
{

    /**
     * Get orders for specified params
     *
     * @param  array  $params
     * @return Request
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function getOrders(array $params = []): Request
    {
        return $this->handleRequest('get', "orders", $params);
    }

    /**
     * @param  int  $id
     * @return Request
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function getOrderById(int $id): Request
    {
        return $this->handleRequest('get', "orders/{$id}");
    }

    /**
     * @param  string  $extId
     * @return Request
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function getOrderByExtId(string $extId): Request
    {
        return $this->handleRequest('get', "orders/ext-id/{$extId}");
    }

    /**
     * @param  int  $id
     * @return Request
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function cancelOrderById(int $id): Request
    {
        return $this->handleRequest('put', "orders/{$id}/cancel");
    }

    /**
     * @param  array  $data
     * @return Request
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function createOrder(array $data): Request
    {
        return $this->handleRequest('post', "orders", [], $data);
    }
}