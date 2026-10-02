<?php

namespace App\Http\Controllers;

use App\Support\LinkChecker;
use App\Support\SafeUrl;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/** JSON API for the Broken Link Checker: list a page's links, then check them in small batches. */
class LinkCheckerController extends Controller
{
    public function __construct(private LinkChecker $checker)
    {
    }

    public function extract(Request $request): JsonResponse
    {
        $url = SafeUrl::normalize((string) $request->input('url', ''));
        // Problems with the address are normal outcomes for this tool, so they are 200 + {error}.
        $result = $url === null ? ['error' => 'invalid-url'] : $this->checker->extract($url);

        return response()->json($result)->header('Cache-Control', 'no-store');
    }

    public function check(Request $request): JsonResponse
    {
        $data = $request->validate([
            'urls' => ['required', 'array', 'min:1', 'max:20'],
            'urls.*' => ['required', 'string', 'max:2048', 'regex:#^https?://#i'],
        ]);

        return response()->json(['results' => $this->checker->check(array_values($data['urls']))])->header('Cache-Control', 'no-store');
    }
}
