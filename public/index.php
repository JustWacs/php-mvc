<?php

// Load file routes

require_once dirname(__DIR__)."/app/init.php";
// Menangani request
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Jalankan routing
Route::dispatch($method, $uri);
