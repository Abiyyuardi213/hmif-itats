<?php

namespace App\Services;

class VoterIdentifier
{
    public static function normalize(string $identifier): string
    {
        return strtoupper(preg_replace('/\s+/', '', trim($identifier)) ?? '');
    }

    public static function hash(string $identifier): string
    {
        $normalized = self::normalize($identifier);

        return hash_hmac('sha256', $normalized, (string) config('app.key'));
    }

    public static function mask(string $identifier): string
    {
        $normalized = self::normalize($identifier);
        $length = strlen($normalized);

        if ($length <= 4) {
            return str_repeat('*', $length);
        }

        return substr($normalized, 0, 4).str_repeat('*', max(2, $length - 6)).substr($normalized, -2);
    }
}
