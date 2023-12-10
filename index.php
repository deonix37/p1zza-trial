<?php

use App\DB;
use App\Router;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/app/routes/orders.php';

DB::connect();
Router::handle();
