# Country Information System

A Laravel-based web and API application that displays country information, supports search and filtering, tracks country views, and highlights trending countries based on recent activity.

---

## 🚀 Features

- Browse all countries with pagination
- Search by country name or capital
- Filter countries by region
- View detailed country information
- Track country page views
- Display trending countries (last 24 hours)
- REST API support (JSON responses)

---

## 🛠 Tech Stack

- **Backend:** Laravel 12, PHP 8.2
- **Database:** MySQL
- **API Client:** RestCountries API
- **Caching:** Laravel Cache
- **Frontend:** Blade Templates (HTML + CSS)

---

## Installation & Setup

### 1. Clone the repository

```bash
git clone https://github.com/abeyrajan7/country-information-system-medVi.git
cd country-information-system-medVi
```

## 2. Required Storage Setup

After cloning the repository, ensure Laravel storage directories exist:

```bash
mkdir -p storage/framework/views
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p bootstrap/cache
> Note: On Linux servers, you may need to adjust permissions for `storage` and `bootstrap/cache`.
```

### 3. Install dependencies

composer install

### 4. Environment setup

cp .env.example .env
php artisan key:generate

### 5. Configure database

DB_DATABASE=country_db
DB_USERNAME=root
DB_PASSWORD=

### 6. Run migrations

php artisan migrate

### 7. Seed countries data

php artisan db:seed
(This may take a few minutes due to API enrichment.)

### 8. Start the server

php artisan serve
App will be available at:

http://127.0.0.1:8000

## API Endpoints

| Method | Endpoint                  | Description                                |
| ------ | ------------------------- | ------------------------------------------ |
| GET    | `/countries`              | List countries (search & filter supported) |
| GET    | `/countries/{code}`       | Get country details                        |
| GET    | `/countries?search=india` | Search countries                           |
| GET    | `/countries?region=Asia`  | Filter by region                           |

(Add Accept: application/json header to receive JSON responses.)

## Trending Logic

Trending countries are calculated based on the number of page views recorded in the last 24 hours.
Uses country_views table
Calculated using server-side aggregation
Excludes disputed or maritime borders (API-driven)

### Border Data Disclaimer

Borders are derived from the RestCountries API and include only internationally recognized land borders.
Disputed or maritime borders (e.g., India–Afghanistan, India–Sri Lanka) are intentionally excluded.

## Environment Variables

The following environment variables must be configured in your `.env` file:
```bash
### Application
APP_NAME=Country Information System  
APP_ENV=local  
APP_KEY=base64:generated-via-artisan  
APP_DEBUG=true  
APP_URL=http://127.0.0.1:8000  

### Database
DB_CONNECTION=mysql  
DB_HOST=127.0.0.1  
DB_PORT=3306  
DB_DATABASE=country_db  
DB_USERNAME=root  
DB_PASSWORD=  

### Cache (used for API caching)
CACHE_DRIVER=file  

### External API
No API key is required.  
This application consumes the public RestCountries API.
```

## ❓ Assumptions & Design Decisions

- Country border data is sourced directly from the RestCountries API.
  Only internationally recognized land borders are included.
  Disputed or maritime borders (e.g., India–Afghanistan, India–Sri Lanka) are excluded.

- Trending countries are calculated based on anonymous page views
  recorded within the last 24 hours.
  No user authentication or deduplication is applied.

- External API responses are cached to improve performance
  and reduce dependency on third-party availability.

- Authentication, authorization, and rate limiting were considered
  out of scope for this assessment.

### License

This project is for educational and evaluation purposes.

## 📘 API Documentation

OpenAPI spec available in `openapi.yaml`
