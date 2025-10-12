# Web Scraper Application

A powerful web scraping application built with Laravel and Filament for managing and viewing scraped articles with advanced filtering and categorization features.

## Features

- **Article Management**: Create, read, update, delete articles with rich content support
- **Advanced Filtering**: Filter articles by category, author, source, and status
- **Article Duplication**: Easily duplicate existing articles with one click
- **Live Preview**: View published articles directly from the admin panel
- **Related Content**: Automatic related article suggestions by category, author, and source
- **Status Management**: Draft, published, and archived article states
- **Filament Admin Panel**: Modern, responsive admin interface
- **Web Scraping**: Automated content collection from various sources

## Requirements

- PHP 8.1 or higher
- Composer
- MySQL 5.7+ or MariaDB 10.3+
- Node.js & NPM
- XAMPP/WAMP/LAMP or similar local development environment

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

4. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure Database**
   - Create a MySQL database named `webscraper`
   - Update your `.env` file with database credentials:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=webscraper
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Run Migrations**
   ```bash
   php artisan migrate
   ```

7. **Seed Database (Optional)**
   ```bash
   php artisan db:seed
   ```

8. **Create Admin User**
   ```bash
   php artisan make:filament-user
   ```

9. **Build Assets**
   ```bash
   npm run build
   ```

10. **Start Development Server**
    ```bash
    php artisan serve
    ```

## Usage

### Accessing the Application

- **Admin Panel**: Visit `http://localhost:8000/admin`
- **Public Site**: Visit `http://localhost:8000`

### Managing Articles

1. **Creating Articles**
   - Navigate to Articles in the admin panel
   - Click "New Article"
   - Fill in title, content, category, author, and source
   - Set status (draft/published)

2. **Viewing Articles**
   - Click on any article to view details
   - See related articles by category, author, and source
   - Use "View Live" button for published articles

3. **Duplicating Articles**
   - In article view, click "Duplicate Article"
   - Article will be copied with "Copy of" prefix
   - Status automatically set to draft

### Web Scraping

Configure scraping sources in your `.env` file and use the built-in scraping commands:

```bash
php artisan scrape:articles
```

## Configuration

### Environment Variables

Key environment variables to configure:

```env
# Application
APP_NAME="Web Scraper"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=webscraper
DB_USERNAME=root
DB_PASSWORD=

# Mail (for notifications)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls

# Scraping Settings
SCRAPING_ENABLED=true
SCRAPING_DELAY=2
MAX_ARTICLES_PER_SOURCE=100
```

## File Structure

```
webscraper/
├── app/
│   ├── Filament/
│   │   └── Resources/
│   │       └── Articles/
│   │           └── Pages/
│   │               └── ViewArticle.php
│   ├── Models/
│   ├── Http/
│   └── Console/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   └── js/
└── public/
```

## API Endpoints

- `GET /api/articles` - List all published articles
- `GET /api/articles/{slug}` - Get specific article
- `GET /api/categories` - List all categories
- `GET /api/sources` - List all sources

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Submit a pull request

## Troubleshooting

### Common Issues

1. **Permission Errors**
   ```bash
   chmod -R 775 storage/
   chmod -R 775 bootstrap/cache/
   ```

2. **Database Connection Issues**
   - Verify MySQL is running
   - Check database credentials in `.env`
   - Ensure database exists

3. **Filament Issues**
   ```bash
   php artisan filament:install --panels
   ```

## License

This project is licensed under the MIT License.

## Support

For support, please contact [your-email@example.com] or create an issue in the repository.