<?php

namespace App\Http\Controllers;

use App\Support\DomainInfo;
use App\Support\OpenPageRank;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/** Bulk Domain Authority Checker: OpenPageRank scores for up to 100 domains. */
class DomainAuthorityController extends Controller
{
    public const MAX_DOMAINS = 100;

    public function check(Request $request, OpenPageRank $opr): JsonResponse
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
            $domain = OpenPageRank::normalize($input);
            $domain === null ? $invalid[] = mb_substr($input, 0, 100) : $valid[$domain] = true;
        }
        $valid = array_keys($valid);
        if (count($valid) > self::MAX_DOMAINS) {
            return response()->json(['error' => 'too-many'], 422);
        }
        if ($valid === []) {
            return response()->json(['results' => [], 'invalid' => $invalid, 'as_of' => null]);
        }
        // Expected problems are normal outcomes for visitors, so they are 200 + {error}.
        if (! $opr->configured()) {
            return response()->json(['error' => 'not-configured']);
        }

        $result = $opr->lookup($valid);
        if (isset($result['error'])) {
            return response()->json($result);
        }

        return response()->json($result + ['invalid' => $invalid])->header('Cache-Control', 'no-store');
    }

    /** One domain's full report: registration, DNS, hosting network, HTTPS and score. */
    public function details(Request $request, DomainInfo $info): JsonResponse
    {
        $data = $request->validate(['domain' => ['required', 'string', 'max:2048']]);
        $domain = OpenPageRank::normalize($data['domain']);
        if ($domain === null) {
            return response()->json(['error' => 'invalid'], 422);
        }

        return response()->json($info->lookup($domain))->header('Cache-Control', 'no-store');
    }
}
