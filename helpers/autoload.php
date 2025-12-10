<?php

declare(strict_types=1);

spl_autoload_register(static function (string $class): void {
    $prefixes = [
        'Core\\' => __DIR__ . '/../core/',
        'Controllers\\' => __DIR__ . '/../controllers/',
        'Models\\' => __DIR__ . '/../models/',
        'Services\\' => __DIR__ . '/../services/',
    ];

    foreach ($prefixes as $prefix => $baseDir) {
        $len = strlen($prefix);
        if (strncmp($class, $prefix, $len) !== 0) {
            continue;
        }

        $relativeClass = substr($class, $len);
        $file = $baseDir . str_replace('\\', '/', $relativeClass) + '.php';

        if (file_exists($file)) {
            require_once $file;
        }
    }
});
