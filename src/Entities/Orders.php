<?php

namespace AcutFulfillment\Wms\Entities;

trait Orders
{

    public function getOrders(array $params = [])
    {
        return $this->handleRequest('get', 'orders');
    }
}