<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    /**
     * Transform the country model into a lightweight API response.
     * Used for country listing endpoints.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'official_name' => $this->official_name,
            'population' => $this->population,
            'region' => $this->region,
            'capital' => $this->capital,
            'flag_url' => $this->flag_url,
        ];
    }
}
