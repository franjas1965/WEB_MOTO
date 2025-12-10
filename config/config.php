<?php

declare(strict_types=1);

$config = [
    'app' => [
        'name' => 'DrPitbike',
        'base_url' => getenv('APP_BASE_URL') ?: 'http://localhost',
    ],
    'pricing' => [
        'vip_discount_percentage' => 0.15,
    ],
    'database' => [
        'host' => getenv('DB_HOST') ?: 'database-5019176865.webspace-host.com',
        'name' => getenv('DB_NAME') ?: 'dbs15058228',
        'user' => getenv('DB_USER') ?: 'dbu5603976',
        'password' => getenv('DB_PASSWORD') ?: '',
        'charset' => 'utf8mb4',
    ],
    'stripe' => [
        'secret_key' => getenv('STRIPE_SECRET_KEY') ?: 'sk_test_placeholder',
        'public_key' => getenv('STRIPE_PUBLIC_KEY') ?: 'pk_test_placeholder',
        'webhook_secret' => getenv('STRIPE_WEBHOOK_SECRET') ?: 'whsec_placeholder',
    ],
];

$localConfigFile = __DIR__ . '/config.local.php';

if (file_exists($localConfigFile)) {
    $localOverrides = require $localConfigFile;
    if (is_array($localOverrides)) {
        $config = array_replace_recursive($config, $localOverrides);
    }
}

return $config;
