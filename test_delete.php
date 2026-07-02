<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Check if the _method middleware is active
$httpKernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$middlewareGroups = $app['router']->getMiddlewareGroups();

echo "=== Middleware Groups ===" . PHP_EOL;
foreach ($middlewareGroups as $group => $middlewares) {
    echo "\nGroup: $group" . PHP_EOL;
    foreach ($middlewares as $m) {
        echo "  - " . (is_string($m) ? $m : get_class($m)) . PHP_EOL;
    }
}

echo PHP_EOL . "=== Global Middleware ===" . PHP_EOL;
// In Laravel 11, check the middleware configuration
$ref = new ReflectionClass($httpKernel);
if ($ref->hasProperty('middleware')) {
    $prop = $ref->getProperty('middleware');
    $prop->setAccessible(true);
    $globalMiddleware = $prop->getValue($httpKernel);
    foreach ($globalMiddleware as $m) {
        echo "  - $m" . PHP_EOL;
    }
}
