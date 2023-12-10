<?php

use App\Controllers\OrderCreateController;
use App\Controllers\OrderItemsAddController;
use App\Controllers\OrderListController;
use App\Controllers\OrderMarkDoneController;
use App\Controllers\OrderShowController;
use App\Router;

Router::add(
    'GET',
    '/orders',
    OrderListController::class
);
Router::add(
    'POST',
    '/orders',
    OrderCreateController::class
);
Router::add(
    'GET',
    '/orders/(?<order_id>[\w-]+)',
    OrderShowController::class
);
Router::add(
    'POST',
    '/orders/(?<order_id>[\w-]+)/items',
    OrderItemsAddController::class
);
Router::add(
    'POST',
    '/orders/(?<order_id>[\w-]+)/done',
    OrderMarkDoneController::class
);
