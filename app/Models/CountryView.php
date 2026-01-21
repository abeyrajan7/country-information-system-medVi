<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CountryView extends Model
{
    /**
     * Allow mass assignment for analytics tracking.
     */
    protected $fillable = ['country_id'];

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = true;

    /**
     * The country this view belongs to.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
