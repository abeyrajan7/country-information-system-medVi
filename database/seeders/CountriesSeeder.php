<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Services\CountryApiService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesSeeder extends Seeder
{
    /**
     * Seed countries and their borders using REST Countries API.
     */
    public function run(): void
    {
        /** @var CountryApiService $apiService */
        $apiService = app(CountryApiService::class);

        $this->command->info(
            'Seeding countries (this may take a minute due to API enrichment)...'
        );

        $countriesData = $apiService->fetchAllCountries();

        DB::transaction(function () use ($countriesData, $apiService) {

            // PASS 1: Create / update countries
            foreach ($countriesData as $item) {
                if (!isset($item['cca3'])) {
                    continue;
                }

                $details = $apiService->fetchCountryByCode($item['cca3']);
                if (empty($details)) {
                    continue;
                }

                Country::updateOrCreate(
                    ['iso_alpha3' => $item['cca3']],
                    [
                        'iso_alpha2'       => $item['cca2'] ?? ($details['cca2'] ?? null),
                        'common_name'      => $item['name']['common'] ?? ($details['name']['common'] ?? null),
                        'official_name'    => $details['name']['official'] ?? null,
                        'region'           => $details['region'] ?? null,
                        'sub_region'       => $details['subregion'] ?? null,
                        'capital'          => $details['capital'][0] ?? null,
                        'population'       => $details['population'] ?? 0,
                        'flag_url'         => $details['flags']['png'] ?? null,
                        'top_level_domain' => $details['tld'][0] ?? null,
                        'currencies'       => $details['currencies'] ?? null,
                        'languages'        => $details['languages'] ?? null,
                    ]
                );
            }

            $this->command->info('Linking borders...');

            // PASS 2: Attach borders
            foreach ($countriesData as $item) {
                if (empty($item['borders']) || empty($item['cca3'])) {
                    continue;
                }

                $country = Country::where('iso_alpha3', $item['cca3'])->first();
                if (! $country) {
                    continue;
                }

                $neighborIds = Country::whereIn('iso_alpha3', $item['borders'])
                    ->pluck('id');

                $country->neighbors()->syncWithoutDetaching($neighborIds);
            }
        });
    }
}
