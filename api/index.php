<?php

if (($_ENV['VERCEL'] ?? getenv('VERCEL')) || ($_ENV['APP_ENV'] ?? getenv('APP_ENV')) === false) {
    $defaults = [
        'APP_NAME' => 'Asif Raza Perfumes',
        'APP_ENV' => 'production',
        'APP_KEY' => 'base64:u6b+n+/T7RkLd0oXz1Czw+YAl6S1xJS1WMFbZl7XiBQ=',
        'APP_DEBUG' => 'false',
        'APP_URL' => 'https://perfumeasif.vercel.app',
        'ASSET_URL' => 'https://perfumeasif.vercel.app',
        'DB_CONNECTION' => 'sqlite',
        'DB_DATABASE' => __DIR__.'/../database/database.sqlite',
        'SESSION_DRIVER' => 'cookie',
        'CACHE_STORE' => 'array',
        'LOG_CHANNEL' => 'stderr',
        'QUEUE_CONNECTION' => 'sync',
        'VIEW_COMPILED_PATH' => '/tmp/laravel-views',
        'APP_SERVICES_CACHE' => '/tmp/laravel-cache/services.php',
        'APP_PACKAGES_CACHE' => '/tmp/laravel-cache/packages.php',
        'APP_CONFIG_CACHE' => '/tmp/laravel-cache/config.php',
        'APP_ROUTES_CACHE' => '/tmp/laravel-cache/routes.php',
        'APP_EVENTS_CACHE' => '/tmp/laravel-cache/events.php',
    ];

    foreach ($defaults as $key => $value) {
        if (($_ENV[$key] ?? getenv($key)) === false) {
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
            putenv($key.'='.$value);
        }
    }
}

foreach (['/tmp/laravel-views', '/tmp/laravel-cache', '/tmp/laravel-sessions', '/tmp/laravel-storage/framework/cache/data'] as $directory) {
    if (! is_dir($directory)) {
        mkdir($directory, 0777, true);
    }
}

$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = __DIR__.'/../public/index.php';

require __DIR__.'/../public/index.php';
