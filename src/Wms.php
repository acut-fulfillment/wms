<?php

namespace AcutFulfillment\Wms;

use AcutFulfillment\Wms\Entities\Items;
use AcutFulfillment\Wms\Entities\Orders;
use AcutFulfillment\Wms\Entities\Returns;
use AcutFulfillment\Wms\Entities\Shipments;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;

class Wms extends Request
{
    /**
     * @param  string  $apiKey
     * @param  string  $user
     * @param  string  $password
     */
    public function __construct(string $apiKey, string $user, string $password)
    {
        parent::__construct($apiKey, $user, $password);
    }
}