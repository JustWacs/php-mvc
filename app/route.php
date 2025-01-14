<?php
class Route {
    private static $routes = [];

    public static function __callStatic($name, $arguments) {
        $method = strtoupper($name);
        $uri = $arguments[0];
        $action = $arguments[1];

        if (!in_array($method, ['GET', 'POST', 'PUT', 'DELETE'])) {
            throw new Exception("Metode HTTP $method tidak didukung.");
        }

        self::$routes[$method][$uri] = $action;
    }

    public static function dispatch($method, $uri) {
        $method = strtoupper($method);
        if (!isset(self::$routes[$method][$uri])) {
            http_response_code(404);
            echo "404 Not Found";
            return;
        }
        list($controller, $action) = explode('@', self::$routes[$method][$uri]);
        if (!class_exists($controller) || !method_exists($controller, $action)) {
            http_response_code(500);
            echo "Controller atau metode tidak ditemukan.";
            return;
        }
        $controllerInstance = new $controller();
        echo $controllerInstance->$action();
    }
}


// Menambahkan route
Route::get('/home', "HomeController@index");