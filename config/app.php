<?php

return [
    'name' => env('APP_NAME', 'FitZone'),
    'env' => env('APP_ENV', 'local'),
    'debug' => (bool) env('APP_DEBUG', true),
    'url' => env('APP_URL', 'http://localhost:8000'),
    'timezone' => 'UTC',
    'locale' => env('APP_LOCALE', 'vi'),
    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),
    'faker_locale' => env('APP_FAKER_LOCALE', 'vi_VN'),
    'cipher' => 'AES-256-CBC',
    'key' => env('APP_KEY', 'base64:IDDBhqLNXPvGnUjsqA5cvI/kkth15X65cG6SbZmZLNg='),
    'previous_keys' => [],
    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],
];