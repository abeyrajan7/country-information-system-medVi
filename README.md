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

## 📦 Installation & Setup

### 1. Clone the repository

```bash
git clone https://github.com/your-username/country-information-system.git
cd country-information-system
```

### 1. Install dependencies

composer install

### 2. Environment setup

cp .env.example .env
php artisan key:generate

### 3. Configure database

DB_DATABASE=country_db
DB_USERNAME=root
DB_PASSWORD=

### 4. Run migrations

php artisan migrate

### 5. Seed countries data

php artisan db:seed
(This may take a few minutes due to API enrichment.)

### 6. Start the server

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


### License
This project is for educational and evaluation purposes.

## 📘 API Documentation
OpenAPI spec available in `openapi.yaml`
