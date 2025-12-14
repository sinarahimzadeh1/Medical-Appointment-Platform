<?php

namespace cookieManager;

class CookieManager
{
    public static function set(string $name, string $value, int $days = 30, bool $secure = false, bool $httpOnly = true): bool
    {
        $expire = time() + ($days * 86400);
        return setcookie($name, $value, $expire, "/", "", $secure, $httpOnly);
    }

    public static function get(string $name): ?string
    {
        return $_COOKIE[$name] ?? null;
    }

    public static function delete(string $name, bool $secure = false, bool $httpOnly = true): bool
    {
        return setcookie($name, '', time() - 3600, "/", "", $secure, $httpOnly);
    }

    public static function exists(string $name): bool
    {
        return isset($_COOKIE[$name]);
    }
}
