# Web Scraper — News Aggregator

A Laravel 12 application that aggregates news articles from multiple sources (BBC, The Guardian, NewsAPI), normalises them into a unified format, stores them in a database, and exposes them via a REST API and a Filament admin panel.

## Features

- **Multi-source aggregation**: Pulls articles from BBC RSS, The Guardian API, and NewsAPI
- **Unified data model**: All sources are normalised to a single `ArticleDTO` / `Article` format
- **Queue-based fetching**: Articles are fetched via `FetchArticlesJob` for non-blocking background processing
- **REST API**: Three dedicated endpoints to query each news source on demand
- **Filament Admin Panel**: Modern, responsive admin interface for browsing and managing articles
- **Artisan command**: `news:fetch-all` dispatches fetch jobs for all sources at once

## Architecture

```
Request / Artisan command
        │
        ▼
NewsController  ──────────────────────────────┐
        │                                     │
        ▼                                     ▼
AbstractNewsService (fetch → parse → normalise)
        │
   ┌────┴──────────────┐
   │                   │
Fetcher            Parser → Normalizer
(HTTP/RSS)         (raw → []  → ArticleDTO)
```

Each news source has its own `Fetcher`, `Parser`, and `Normalizer` class, all bound by shared interfaces (`FetcherInterface`, `ParserInterface`, `NormalizerInterface`).

## Requirements

- PHP 8.2 or higher
- Composer
- MySQL 5.7+ or MariaDB 10.3+
- Node.js & NPM
- A queue worker (database, Redis, etc.) for background jobs

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd webscraper
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure the database** — update `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=webscraper
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Configure news API keys** — update `.env`:
   ```env
   NEWS_API_KEY=your_newsapi_key
   NEWS_API_URL=https://newsapi.org/v2/top-headlines

   GUARDIAN_API_KEY=your_guardian_key
   GUARDIAN_API_URL=https://content.guardianapis.com/search

   BBC_API_URL=https://feeds.bbci.co.uk/news/rss.xml
   ```

7. **Run migrations**
   ```bash
   php artisan migrate
   ```

8. **Create an admin user**
   ```bash
   php artisan make:filament-user
   ```

9. **Build assets**
   ```bash
   npm run build
   ```

10. **Start the development server**
    ```bash
    php artisan serve
    ```

11. **Start a queue worker** (required for background fetching)
    ```bash
    php artisan queue:work
    ```

## Usage

### Admin Panel

Visit `http://localhost:8000/admin` to browse and manage articles.

### Fetching News

Dispatch background jobs for all sources at once:

```bash
php artisan news:fetch-all
```

This dispatches a `FetchArticlesJob` for each of the three sources (`bbc`, `guardian`, `newsapi`). Articles are upserted by URL so duplicates are handled automatically.

### API Endpoints

| Method | Endpoint | Source | Query params |
|--------|----------|--------|--------------|
| GET | `/api/news` | NewsAPI | `category`, `language` |
| GET | `/api/bbc` | BBC RSS | `language` |
| GET | `/api/guardian` | The Guardian | `category`, `language` |

**Example response item:**
```json
{
  "source": "BBC News",
  "author": null,
  "title": "Article headline",
  "description": "Short summary",
  "content": "Full article text...",
  "url": "https://www.bbc.co.uk/news/...",
  "url_to_image": null,
  "published_at": "2026-03-24 10:00:00",
  "category": "general"
}
```

Returns `500` with `{"error": "..."}` if the upstream source fails.

## File Structure

```
app/
├── Actions/
│   └── StoreOrUpdateArticleAction.php   # Upserts ArticleDTOs into the DB
├── Console/Commands/
│   └── FetchAllNews.php                 # php artisan news:fetch-all
├── Contracts/
│   ├── ContentFetcherInterface.php
│   ├── FetcherInterface.php
│   ├── NormalizerInterface.php
│   ├── NewsSourceInterface.php
│   └── ParserInterface.php
├── DTOs/
│   └── ArticleDTO.php                   # Shared normalised article shape
├── Factories/
│   └── NewsServiceFactory.php           # Resolves service by name string
├── Filament/                            # Admin panel resources
├── Http/Controllers/
│   └── NewsController.php              # REST API (index / bbc / guardian)
├── Jobs/
│   └── FetchArticlesJob.php            # Queueable fetch job
├── Models/
│   ├── Article.php
│   ├── Category.php
│   └── User.php
└── Services/
    ├── AbstractNewsService.php          # Shared fetch → parse → normalise pipeline
    ├── BBC/
    │   ├── BBCNewsService.php
    │   ├── BBCFetcher.php
    │   ├── BBCParser.php
    │   ├── BBCNormalizer.php
    │   └── BBCContentFetcher.php        # Fetches full article body via DOM
    ├── Guardian/
    │   ├── GuardianNewsService.php
    │   ├── GuardianFetcher.php
    │   ├── GuardianParser.php
    │   └── GuardianNormalizer.php
    └── NewsApi/
        ├── NewsApiService.php
        ├── NewsApiFetcher.php
        ├── NewsApiParser.php
        └── NewsApiNormalizer.php
```

## Troubleshooting

**Permission errors**
```bash
chmod -R 775 storage/ bootstrap/cache/
```

**Database connection issues**
- Confirm MySQL is running
- Double-check credentials in `.env`
- Ensure the database exists

**Articles not being stored**
- Confirm a queue worker is running (`php artisan queue:work`)
- Check `storage/logs/laravel.log` for errors from `FetchArticlesJob`

**Filament panel not loading**
```bash
php artisan filament:install --panels
php artisan optimize:clear
```

## License

MIT
