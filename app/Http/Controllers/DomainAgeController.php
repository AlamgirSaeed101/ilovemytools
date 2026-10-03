<?php

namespace App\Http\Controllers;

use App\Support\Rdap;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/** Domain Age Checker: creation/expiry/update dates, registrar, status and nameservers from RDAP. */
class DomainAgeController extends Controller
{
    public const MAX_DOMAINS = 20;

    public function check(Request $request, Rdap $rdap): JsonResponse
    {
        $data = $request->validate([
            'domains' => ['required', 'array', 'min:1', 'max:'.(self::MAX_DOMAINS * 2)],
            'domains.*' => ['nullable', 'string', 'max:2048'],
        ]);

        $valid = [];
        $invalid = [];
        foreach ($data['domains'] as $input) {
            $input = trim((string) $input);
            if ($input === '') {
                continue;
            }
            $domain = Rdap::normalize($input);
            $domain === null ? $invalid[] = mb_substr($input, 0, 100) : $valid[$domain] = true;
        }
        $valid = array_keys($valid);
        if (count($valid) > self::MAX_DOMAINS) {
            return response()->json(['error' => 'too-many'], 422);
        }
        if ($valid === []) {
            return response()->json(['results' => [], 'invalid' => $invalid]);
        }

        $results = array_map(fn ($domain) => ['domain' => $domain] + $rdap->lookup($domain), $valid);

        return response()->json(['results' => $results, 'invalid' => $invalid])->header('Cache-Control', 'no-store');
    }
}
