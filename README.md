# acut fulfillment WMS PHP-SDK

This is the offical PHP-SDK for connecting to the acut fulfillment WMS API.


[![MIT License](https://img.shields.io/badge/License-MIT-green.svg)](https://choosealicense.com/licenses/mit/)


## Prerequisites

- PHP >= 8.1
- Valid API-Key for the acut fulfillment WMS
- Valid useraccount for the acut fulfillment Client Dashboard

## Installation

The recommended way to install this SDK is through [composer](https://getcomposer.org/).


```bash
composer require acut-fulfillment/wms
```

## Getting started

The following code is all you need to get all your orders paginated.

```php
require 'vendor/autoload.php';

$wms = new AcutFulfillment\Wms\Wms(
    apiKey: 'YOUR_API_KEY',
    user: 'YOUR_USERNAME',
    password: 'YOUR_PASSWORD'
);

$req = $wms->getOrders();

if ($req->failed()) {
    echo "Request failed with status {$req->getStatus()} and message {$req->getMessage()}";
} else {
    $orders = $req->getResponse();

    foreach ($orders['data'] as $order) {
        // ...
    }
}
```

If you want to use query parameters like page oder page_size you can do it as follows

```php
$req = $wms->getOrders([
    'current_status' => 1, // returns only open orders
    'page' => 1, // returns the first page
    'page_size' => 10 // returns max. 10 entries per page
]);
```

## Functions and params

| Entity | Method | Function and params                 | Description                                                 |
|--------|--------|-------------------------------------|-------------------------------------------------------------|
| Orders | `GET`  | `getOrders(array $params = [])`     | Get paginated orders                                        |
 | Orders | `GET`  | `getOrderById(int $id)`             | Get a single order by its id                                |
| Orders | `GET`  | `getOrderByExtId(string $extId)`    | Get a single orders by its external id                      |
| Orders | `PUT`  | `cancelOrderById(int $id)`          | Cancel order by its id                                      |
| Orders | `POST` | `createOrder(array $data)`          | Create an order (see [example](https://api.wms.acut-services.de/swagger#/Orders/post-orders))                               |
| Items  | `GET`  | `getItems(array $params = [])`      | Get paginated items                                         |
| Items  | `GET`  | `getItemById(int $id)`              | Get a single item by its id                                 |
| Items  | `GET`  | `getItemByBarcode(string $barcode)` | Get a single item by one of its barcodes (can have several) |

## Swagger documentation

You can find the swagger documentation [here](https://api.wms.acut-services.de/swagger)

## Support

For support, send an email to dominic@acut-fulfillment.de
