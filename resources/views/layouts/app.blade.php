<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Country Information System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        /* =========================
           1. BASE
        ========================== */
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            color: #111;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        img {
            max-width: 100%;
            display: block;
            border-radius: 8px;
        }

        /* =========================
           2. LAYOUT
        ========================== */
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 24px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 32px;
            margin-top: 1%;
        }

        /* =========================
           3. COUNTRY CARD
        ========================== */
        .card {
            background: #fff;
            border-radius: 12px;
            padding: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.15s ease;
            display: flex;
            flex-direction: column;
        }

        .card:hover {
            transform: translateY(-4px);
        }

        .card img {
            height: 160px;
            object-fit: cover;
            margin-bottom: 12px;
        }

        .card h3 {
            margin: 8px 0 12px;
            font-size: 18px;
        }

        .card p {
            margin: 6px 0;
            font-size: 14px;
        }

        /* =========================
           4. TRENDING SECTION
        ========================== */
        .trending-grid {
            display: flex;
            gap: 16px;
            overflow-x: auto;
            padding-bottom: 12px;
            margin-bottom: 40px;
        }

        .trending-card {
            min-width: 220px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.06);
            position: relative;
            overflow: hidden;
        }

        /* Accent bar */
        .trending-card::before {
            content: "";
            display: block;
            height: 6px;
            width: 100%;
        }

        /* Rank colors */
        .rank-1::before { background: #FFD700; } /* Gold */
        .rank-2::before { background: #C0C0C0; } /* Silver */
        .rank-3::before { background: #CD7F32; } /* Bronze */
        .rank-4::before { background: #6B7280; }
        .rank-5::before { background: #9CA3AF; }

        .trending-card img {
            height: 130px;
            object-fit: cover;
        }

        .rank-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 13px;
            padding: 4px 8px;
            border-radius: 6px;
            font-weight: 600;
            background: #f3f4f6;
        }

        .rank-1 .rank-badge { background: #FFD700; }
        .rank-2 .rank-badge { background: #E5E7EB; }
        .rank-3 .rank-badge { background: #EAC086; }

        /* =========================
           5. SEARCH & FILTER
        ========================== */
        .search-bar {
            display: flex;
            gap: 12px;
            margin-bottom: 32px;
            align-items: center;
        }

        .search-wrapper {
            position: relative;
            flex: 1;
        }

        .search-input {
            width: 100%;
            height: 44px;
            padding: 0 44px 0 14px;
            font-size: 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        .search-icon-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: none;
            cursor: pointer;
            font-size: 18px;
        }

        .filter-select,
        .filter-btn {
            height: 44px;
            font-size: 15px;
            border-radius: 8px;
        }

        .filter-select {
            padding: 0 14px;
            border: 1px solid #ccc;
            background: #fff;
            min-width: 140px;
        }

        .filter-btn {
            padding: 0 18px;
            border: 2px solid #000;
            background: #fff;
            font-weight: 600;
            cursor: pointer;
        }

        .filter-btn:hover {
            background: #000;
            color: #fff;
        }

        /* =========================
           6. UTILITIES
        ========================== */
        .badge {
            display: inline-block;
            padding: 6px 10px;
            background: #eef1f5;
            border-radius: 4px;
            font-size: 14px;
        }

        .badge.active {
            background: #0066cc;
            color: #fff;
            font-weight: bold;
        }

        /* =========================
            COUNTRY SHOW PAGE
        ========================= */
        .country-detail-wrapper {
            background: #ffffff;
            border-radius: 16px;
            padding: 40px;
            margin-top: 20px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.06);
        }

        /* Improve vertical rhythm */
        .country-info > * {
            margin-bottom: 22px;
        }

        .info-grid p {
            margin: 6px 0;
        }

        /* Improve section separation */
        .section {
            margin-top: 28px;
        }

        /* Limit max width for readability */
        .country-detail {
            max-width: 1000px;
            display: grid;
            grid-template-columns: 420px 1fr;
            gap: 40px;
            align-items: start;
            margin-top: 24px;
        }

        .country-flag img {
            width: 100%;
            height: auto;
            border-radius: 14px;
            box-shadow: 0 6px 16px rgba(0,0,0,0.12);
        }

        .country-info h1 {
            margin-top: 0;
            font-size: 32px;
            margin-bottom: 20px;
        }

        .country-flag img {
            max-height: 280px;
            object-fit: cover;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(200px, 1fr));
            gap: 12px 24px;
            margin-bottom: 24px;
        }

        .section {
            margin-bottom: 24px;
        }

        .section h3 {
            margin-bottom: 10px;
            font-size: 18px;
        }

        .pill {
            display: inline-block;
            padding: 6px 12px;
            background: #eef1f5;
            border-radius: 999px;
            font-size: 14px;
            margin: 4px 6px 0 0;
        }

        .muted {
            color: #666;
            font-size: 14px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: 8px;
            background: #2291ff;
            color: #fcfcfc;
            margin: 2%;
            font-size: 14px;
            font-weight: 500;
            transition: background 0.15s ease, transform 0.15s ease;
        }

        .back-btn:hover {
            background: #e5e7eb;
            transform: translateX(-2px);
            color: #000000;
        }

        /* =========================
           7. RESPONSIVE
        ========================== */
        @media (max-width: 768px) {
            .search-bar {
                flex-direction: column;
                align-items: stretch;
            }
        }

        @media (max-width: 900px) {
            .country-detail {
                grid-template-columns: 1fr;
            }
        }

    </style>
</head>
<body>

<div class="container">
    @yield('content')
</div>

</body>
</html>
