<?php

namespace App\Services;

use App\Models\Country;
use App\Models\CountryView;
use Illuminate\Support\Collection;

class CountryAnalyticsService
{
    /**
     * Track a page view for the given country.
     */
    public function trackView(Country $country): void
    {
        CountryView::create([
            'country_id' => $country->id,
        ]);
    }

    /**
     * Retrieve trending countries based on views in the last 24 hours.
     *
     * @param int $limit
     * @return Collection
     */
    public function getTrending(int $limit = 5): Collection
    {
        return Country::trending($limit);
    }
}
