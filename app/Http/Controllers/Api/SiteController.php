<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Support\SiteData;
use Illuminate\Http\JsonResponse;

/**
 * Read-only JSON API for the React front end. Everything here comes from
 * config/*.php, so responses are cacheable by browsers and CDNs.
 */
class SiteController extends Controller
{
    public function __construct(private SiteData $data)
    {
    }

    public function site(): JsonResponse
    {
        return $this->json($this->data->site());
    }

    public function tool(string $slug): JsonResponse
    {
        $tool = $this->data->tool($slug);

        return $tool === null ? $this->missing('Tool not found.') : $this->json($tool);
    }

    public function category(string $slug): JsonResponse
    {
        $category = $this->data->category($slug);

        return $category === null ? $this->missing('Category not found.') : $this->json($category);
    }

    private function json(array $payload): JsonResponse
    {
        return response()->json($payload)->header('Cache-Control', 'public, max-age=300');
    }

    private function missing(string $message): JsonResponse
    {
        return response()->json(['message' => $message], 404);
    }
}
