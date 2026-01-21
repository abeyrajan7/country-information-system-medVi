<?php

namespace App\Http\Controllers;

use App\Http\Resources\CountryDetailResource;
use App\Http\Resources\CountryResource;
use App\Models\Country;
use App\Services\CountryAnalyticsService;

class CountryController extends Controller
{
    public function __construct(
        protected CountryAnalyticsService $analytics
    ) {}
    /**
     * Display a paginated list of countries with optional search and region filtering.
     *
     * @return View|AnonymousResourceCollection
     */
    public function index()
    {
        $countries = Country::query()
            ->when(request('search'), fn ($q) => $q->search(request('search')))
            ->when(request('region'), fn ($q) => $q->byRegion(request('region')))
            ->paginate(12)
            ->appends(request()->query());

        // API client (Postman, curl, fetch, axios)
        if (request()->wantsJson()) {
            return CountryResource::collection($countries);
        }

        $trendingCountries = $this->analytics->getTrending(5);

        // Browser
        return view('countries.index', compact('countries', 'trendingCountries'));
    }


    /**
     * Display detailed information for a single country.
     *
     * @param string $code ISO Alpha-3 country code
     * @return View|CountryDetailResource
     */
    public function show(string $code)
    {
        $country = Country::where('iso_alpha3', strtoupper($code))
            ->with(['neighbors', 'neighboringCountries'])
            ->firstOrFail();

        if (request()->wantsJson()) {
            return new CountryDetailResource($country);
        }

        // 🔹 Track the view
        $this->analytics->trackView($country);

        return view('countries.show', compact('country'));
    }

}
