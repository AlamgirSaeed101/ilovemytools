<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Throwable;

/**
 * OpenPageRank lookups (https://openpagerank.keywordseverywhere.com/docs) for the
 * Domain Authority Checker. Scores change monthly, so each domain is cached for a week,
 * and a daily cap keeps the site inside the API plan.
 */
class OpenPageRank
{
    private const ENDPOINT = 'https://openpagerank.keywordseverywhere.com/v1/domains/bulk';

    private const CACHE_DAYS = 7;

    public function configured(): bool
    {
        return (string) config('site.openpagerank.key') !== '';
    }

    /** "https://www.Example.com/page" -> "example.com"; null when it isn't a domain. */
    public static function normalize(string $input): ?string
    {
        $s = strtolower(trim($input));
        $s = preg_replace('#^[a-z][a-z0-9+.-]*://#', '', $s);
        $s = preg_replace('#[/?\#:].*$#', '', $s);
        $s = preg_replace('/^www\./', '', rtrim($s, '.'));

        return preg_match('/^(?=.{3,253}$)([a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z][a-z0-9-]{1,62}$/', $s) ? $s : null;
    }

    /**
     * @param  list<string>  $domains  already normalised, unique
     * @return array{results: list<array{domain: string, found: bool, score: float|null, rank: int|null, referring_domains: int|null}>, as_of: string|null}|array{error: string}
     */
    public function lookup(array $domains): array
    {
        $results = [];
        $missing = [];
        foreach ($domains as $d) {
            $hit = Cache::get("opr:$d");
            $hit === null ? $missing[] = $d : $results[$d] = $hit;
        }

        $asOf = Cache::get('opr:as_of');
        if ($missing !== []) {
            $usedKey = 'opr:used:'.now()->toDateString();
            if (Cache::get($usedKey, 0) + count($missing) > (int) config('site.openpagerank.daily_limit')) {
                return ['error' => 'daily-limit'];
            }
            try {
                $res = Http::withToken((string) config('site.openpagerank.key'))
                    ->acceptJson()
                    ->timeout(20)
                    ->post(self::ENDPOINT, ['domains' => $missing, 'include_history' => false]);
            } catch (Throwable) {
                return ['error' => 'unavailable'];
            }
            if ($res->status() === 429) {
                return ['error' => 'busy'];
            }
            if (! $res->successful()) {
                return ['error' => 'unavailable'];
            }
            Cache::put($usedKey, Cache::get($usedKey, 0) + count($missing), now()->addDays(2));
            $asOf = $res->json('as_of') ?: $asOf;
            Cache::put('opr:as_of', $asOf, now()->addDays(self::CACHE_DAYS));

            foreach ((array) $res->json('results') as $row) {
                $domain = strtolower((string) ($row['domain'] ?? ''));
                $entry = [
                    'domain' => $domain,
                    'found' => (bool) ($row['found'] ?? false),
                    'score' => isset($row['open_page_rank']) ? round((float) $row['open_page_rank'], 2) : null,
                    'rank' => isset($row['rank']) ? (int) $row['rank'] : null,
                    'referring_domains' => isset($row['referring_domains']) ? (int) $row['referring_domains'] : null,
                ];
                Cache::put("opr:$domain", $entry, now()->addDays(self::CACHE_DAYS));
                $results[$domain] = $entry;
            }
        }

        // Keep the visitor's order; domains the API didn't return count as not found.
        return [
            'results' => array_map(fn ($d) => $results[$d] ?? ['domain' => $d, 'found' => false, 'score' => null, 'rank' => null, 'referring_domains' => null], $domains),
            'as_of' => $asOf,
        ];
    }
}
