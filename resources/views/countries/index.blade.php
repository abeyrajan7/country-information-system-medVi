@extends('layouts.app')

@section('content')

<h1>Countries</h1>

{{-- Search --}}
@if ($trendingCountries->count())
    <h2>Trending Countries (Last 24h)</h2>

    <div class="trending-grid">
        @foreach ($trendingCountries as $index => $country)
            @php
                $rank = $index + 1;
            @endphp

            <a href="{{ route('countries.show', $country->iso_alpha3) }}">
                <div class="card trending-card rank-{{ $rank }}">
                    <img src="{{ $country->flag_url }}" alt="{{ $country->official_name }}">

                    <h3>
                        {{ $country->official_name }}
                        <span class="rank-badge">#{{ $rank }}</span>
                    </h3>

                    <p><strong>Views:</strong> {{ $country->views_count }}</p>
                </div>
            </a>
        @endforeach
    </div>
@endif
<form method="GET"
      action="{{ route('countries.index') }}"
      class="search-box">

    {{-- Search input with icon --}}
    <div class="search-wrapper">
        <input
            type="text"
            name="search"
            placeholder="Search by country name or capital..."
            value="{{ request('search') }}"
            class="search-input"
        >

        <button type="submit"
                class="search-icon-btn"
                title="Search">
            🔍
        </button>
    </div>

    {{-- Region dropdown --}}
    <select name="region" class="filter-select">
        <option value="">All Regions</option>
        @foreach (['Africa', 'Americas', 'Asia', 'Europe', 'Oceania'] as $region)
            <option value="{{ $region }}"
                {{ request('region') === $region ? 'selected' : '' }}>
                {{ $region }}
            </option>
        @endforeach
    </select>

    {{-- Filter button --}}
    <button type="submit" class="filter-btn">
        Filter
    </button>
</form>




{{-- Country List --}}
<div class="grid">
    @forelse ($countries as $country)
        <a href="{{ route('countries.show', $country->iso_alpha3) }}">
            <div class="card">
                <img src="{{ $country->flag_url }}" alt="{{ $country->official_name }} flag">

                <div style="flex: 1;">
                    <h3>{{ $country->official_name }}</h3>

                    <p><strong>Population:</strong> {{ number_format($country->population) }}</p>
                    <p><strong>Region:</strong> {{ $country->region }}</p>
                    <p><strong>Capital:</strong> {{ $country->capital }}</p>
                </div>
            </div>

        </a>
    @empty
        <p>No countries found.</p>
    @endforelse
</div>

{{-- Pagination --}}
<div style="margin-top: 24px;">
    @if ($countries->lastPage() > 1)
        <div style="margin-top: 32px; display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">

            {{-- Previous (hidden on first page) --}}
            @if (! $countries->onFirstPage())
                <a href="{{ $countries->previousPageUrl() }}" class="badge">« Prev</a>
            @endif

            {{-- First page --}}
            <a href="{{ $countries->url(1) }}"
            class="badge {{ $countries->currentPage() == 1 ? 'active' : '' }}">
                1
            </a>

            {{-- Left dots --}}
            @if ($countries->currentPage() > 3)
                <span>…</span>
            @endif

            {{-- Middle pages --}}
            @for ($page = max(2, $countries->currentPage() - 1); $page <= min($countries->lastPage() - 1, $countries->currentPage() + 1); $page++)
                <a href="{{ $countries->withQueryString()->url($page) }}"
                class="badge {{ $countries->currentPage() == $page ? 'active' : '' }}">
                    {{ $page }}
                </a>
            @endfor

            {{-- Right dots --}}
            @if ($countries->currentPage() < $countries->lastPage() - 2)
                <span>…</span>
            @endif

            {{-- Last page --}}
            @if ($countries->lastPage() > 1)
                <a href="{{ $countries->url($countries->lastPage()) }}"
                class="badge {{ $countries->currentPage() == $countries->lastPage() ? 'active' : '' }}">
                    {{ $countries->lastPage() }}
                </a>
            @endif

            {{-- Next (hidden on last page) --}}
            @if ($countries->hasMorePages())
                <a href="{{ $countries->nextPageUrl() }}" class="badge">Next »</a>
            @endif

        </div>
    @endif
</div>

@endsection
