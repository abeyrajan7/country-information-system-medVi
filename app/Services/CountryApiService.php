<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Client\Response;

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use RuntimeException;

class CountryApiService {
    /**
     * Base URL for REST Countries API.
     */
    private string $baseUrl = 'https://restcountries.com/v3.1';

    /**
     * Fetch a lightweight list of all countries.
     * Cached to avoid repeated external API calls.
     *
     * @return array<int, mixed>
     */
    public function fetchAllCountries(): array
    {
        return Cache::remember('countries_list', now()->addHours(24), function () {
            /** @var Response $response */
            $response = Http::retry(3, 100)->get(
                "{$this->baseUrl}/all",
                ['fields' => 'name,cca2,cca3,borders']
            );

            if ($response->failed()) {
                throw new RuntimeException(
                    'Failed to fetch country list. Status: ' . $response->status()
                );
            }

            return $response->json();
        });
    }

     /**
     * Fetch full details for a single country by ISO Alpha-3 code.
     * Cached long-term since country metadata rarely changes.
     *
     * @param string $code
     * @return array<string, mixed>
     */
    public function fetchCountryByCode(string $code): array
    {
        return Cache::remember("country_detail_{$code}", now()->addDays(7), function () use ($code) {
            /** @var Response $response */
            $response = Http::retry(3, 100)
                ->get("{$this->baseUrl}/alpha/{$code}");

            if ($response->failed()) {
                throw new RuntimeException(
                    'Failed to fetch country detail. Status: ' . $response->status()
                );
            }

            // API returns an array; we only need the first item
            return $response->json()[0] ?? [];
        });
    }
}
