<?php

namespace App\Models;

use App\Models\CountryView;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Country extends Model
{
    /**
     * Allow mass assignment.
     */
    protected $guarded = [];

    /**
     * Cast JSON columns to arrays.
     */
    protected $casts = [
        'currencies' => 'array',
        'languages' => 'array',
    ];

    /**
     * Countries this country borders.
     */
    public function neighbors(): BelongsToMany
    {
        return $this->belongsToMany(
            Country::class,
            'country_borders',
            'country_id',
            'border_country_id'
        );
    }

    /**
     * Track page views for analytics.
     */
    public function views(): HasMany
    {
        return $this->hasMany(CountryView::class);
    }

    /**
     * Scope: full-text search by country name or capital.
     */
    public function scopeSearch(Builder $query, string $term): Builder
    {
        return $query->where(function (Builder $q) use ($term) {
            $q->where('common_name', 'like', "%{$term}%")
            ->orWhere('capital', 'like', "%{$term}%");
        });
    }

    /**
     * Countries that border this country (reverse direction).
     */
    public function neighboringCountries(): BelongsToMany
    {
        return $this->belongsToMany(
            Country::class,
            'country_borders',
            'border_country_id',
            'country_id'
        );
    }

    /**
     * Get all bordering countries (merged & unique).
     */
    public function allBorders()
    {
        return $this->neighbors
            ->merge($this->neighboringCountries)
            ->unique('id')
            ->values();
    }

    /**
     * Scope: filter countries by region.
     */
    public function scopeByRegion(Builder $query, string $region): Builder
    {
        return $query->where('region', $region);
    }

    /**
     * Get trending countries based on views in the last 24 hours.
     */
    public static function trending(int $limit = 5)
    {
        return self::select('countries.*', DB::raw('COUNT(country_views.id) as views_count'))
            ->join('country_views', 'countries.id', '=', 'country_views.country_id')
            ->where('country_views.created_at', '>=', Carbon::now()->subDay())
            ->groupBy('countries.id')
            ->orderByDesc('views_count')
            ->limit($limit)
            ->get();
    }

}
