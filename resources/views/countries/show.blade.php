@extends('layouts.app')

@section('content')

<a href="{{ route('home') }}" class="back-btn">
    ← Back to countries
</a>

<div class="country-detail-wrapper">
    <div class="country-detail">
        <!-- Left: Flag -->
        <div class="country-flag">
            <img src="{{ $country->flag_url }}" alt="{{ $country->official_name }}">
        </div>

        <!-- Right: Info -->
        <div class="country-info">
            <h1>{{ $country->official_name }}</h1>

            <div class="info-grid">
                <p><strong>Population:</strong> {{ number_format($country->population) }}</p>
                <p><strong>Region:</strong> {{ $country->region }}</p>
                <p><strong>Sub Region:</strong> {{ $country->sub_region }}</p>
                <p><strong>Capital:</strong> {{ $country->capital }}</p>
                <p><strong>Top Level Domain:</strong> {{ $country->top_level_domain }}</p>
            </div>

            <div class="section">
                <h3>Currencies</h3>
                @foreach($country->currencies as $currency)
                    <span class="pill">{{ $currency['name'] }} ({{ $currency['symbol'] ?? '' }})</span>
                @endforeach
            </div>

            <div class="section">
                <h3>Languages</h3>
                @foreach($country->languages as $language)
                    <span class="pill">{{ $language }}</span>
                @endforeach
            </div>

            <div class="section">
                <h3>Border Countries</h3>
                @if ($country->allBorders()->count())
                    @foreach ($country->allBorders() as $neighbor)
                        <span class="pill">{{ $neighbor->common_name }}</span>
                    @endforeach
                @else
                    <p class="muted">No bordering countries.</p>
                @endif
            </div>
        </div>
    </div>
</div>
