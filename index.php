<?php

use App\DB;
use App\Router;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/app/routes/orders.php';

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: *");

DB::connect();
Router::handle();
