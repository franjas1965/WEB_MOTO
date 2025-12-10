<?php

declare(strict_types=1);

namespace Core;

class App
{
    private static array $config = [];

    public static function init(array $config): void
    {
        self::$config = $config;
    }

    /**
     * @param string|null $key dot notation supported e.g. database.host
     */
    public static function config(?string $key = null, mixed $default = null): mixed
    {
        if ($key === null) {
            return self::$config;
        }

        $segments = explode('.', $key);
        $value = self::$config;

        foreach ($segments as $segment) {
            if (!is_array($value) || !array_key_exists($segment, $value)) {
                return $default;
            }

            $value = $value[$segment];
        }

        return $value;
    }
}
