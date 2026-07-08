<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (($_ENV['VERCEL'] ?? getenv('VERCEL')) || ($_ENV['APP_ENV'] ?? getenv('APP_ENV')) === false) {
    $defaults = [
        'APP_NAME' => 'Asif Raza Perfumes',
        'APP_ENV' => 'production',
        'APP_KEY' => 'base64:u6b+n+/T7RkLd0oXz1Czw+YAl6S1xJS1WMFbZl7XiBQ=',
        'APP_DEBUG' => 'false',
        'APP_URL' => 'https://perfumeasif.vercel.app',
        'DB_CONNECTION' => 'sqlite',
        'DB_DATABASE' => __DIR__.'/../database/database.sqlite',
        'SESSION_DRIVER' => 'cookie',
        'CACHE_STORE' => 'array',
        'LOG_CHANNEL' => 'stderr',
        'QUEUE_CONNECTION' => 'sync',
        'VIEW_COMPILED_PATH' => '/tmp/laravel-views',
    ];

    foreach ($defaults as $key => $value) {
        if (($_ENV[$key] ?? getenv($key)) === false) {
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
            putenv($key.'='.$value);
        }
    }
}

foreach (['/tmp/laravel-views', '/tmp/laravel-cache', '/tmp/laravel-sessions'] as $directory) {
    if (! is_dir($directory)) {
        mkdir($directory, 0777, true);
    }
}

$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = __DIR__.'/../public/index.php';

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../vendor/autoload.php';

/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->useStoragePath('/tmp/laravel-storage');

$app->handleRequest(Request::capture());
