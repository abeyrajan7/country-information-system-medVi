<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'official_name'    => $this->official_name,
            'population'       => $this->population,
            'region'           => $this->region,
            'sub_region'       => $this->sub_region,
            'capital'          => $this->capital,
            'top_level_domain' => $this->top_level_domain,
            'flag_url'         => $this->flag_url,

            'currencies' => $this->currencies,
            'languages'  => $this->languages,

            'border_countries' => $this->neighbors->map(fn ($border) => [
                'official_name' => $border->official_name,
                'iso_code'      => $border->iso_alpha3,
                'flag_url'      => $border->flag_url,
            ]),
        ];
    }
}
