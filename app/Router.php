<?php

namespace App;

class Router
{
    private static $routes = [];

    public static function add(
        string $method,
        string $url,
        string $controller
    ): void
    {
        self::$routes[$url][$method] = $controller;
    }

    public static function handle(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach (self::$routes as $routeUrl => $routeGroup) {
            if (!preg_match("#^$routeUrl$#", $path, $matches)) {
                continue;
            }

            if ($method == 'OPTIONS') {
                return;
            }

            if (!($controller = $routeGroup[$method] ?? null)) {
                http_response_code(405);
                return;
            }

            $params = array_filter(
                $matches,
                'is_string',
                ARRAY_FILTER_USE_KEY
            );

            call_user_func_array(new $controller, $params);
            return;
        }

        http_response_code(404);
    }
}
