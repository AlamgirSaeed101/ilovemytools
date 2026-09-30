<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Used by the "What Is My IP" tool. The IP is only echoed back to the
 * visitor; nothing is stored.
 */
class IpController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $ip = self::normalize((string) $request->ip());

        return response()->json([
            'ip' => $ip,
            'version' => self::version($ip),
        ])->header('Cache-Control', 'no-store, max-age=0');
    }

    /** "::ffff:203.0.113.9" (IPv4 over a dual-stack socket) -> "203.0.113.9" */
    public static function normalize(string $ip): string
    {
        if (preg_match('/^::ffff:(\d{1,3}(?:\.\d{1,3}){3})$/i', $ip, $m)) {
            return $m[1];
        }

        return $ip;
    }

    public static function version(string $ip): string
    {
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) ? 'IPv6' : 'IPv4';
    }
}
