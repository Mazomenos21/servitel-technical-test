# Servitel Technical Test

REST API built with Laravel for task management with weather integration.

## Technologies Used

| Category | Technology |
|----------|------------|
| Framework | Laravel 12 |
| PHP | 8.5.3 |
| Frontend | Livewire 4 + Flux UI |
| Admin Panel | Filament 5 |
| Authentication | Laravel Fortify + Sanctum |
| Database | PostgreSQL |
| Cache | Redis |
| Testing | Pest 4 |
| Docker | Laravel Sail |

## Installation

### Using Docker with Sail (Recommended)

```bash
# Clone the repository
git clone https://github.com/your-repo/servitel-technical-test.git
cd servitel-technical-test

# Install dependencies
composer install

# Start Sail (creates containers)
./vendor/bin/sail up -d

# Generate application key
./vendor/bin/sail artisan key:generate

# Run migrations
./vendor/bin/sail artisan migrate

# Seed database (optional)
./vendor/bin/sail artisan db:seed

# Install frontend dependencies
./vendor/bin/sail npm install

# Build frontend assets
./vendor/bin/sail npm run build
```

### Alternative: Manual Setup

```bash
# Install dependencies
composer install
npm install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure database in .env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=servitel-db
DB_USERNAME=root
DB_PASSWORD=password

# Run migrations
php artisan migrate

# Build frontend
npm run build

# Start server
php artisan serve
```

## Configuration

### Environment Variables

```env
# Application
APP_NAME="Servitel Technical Test"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

# Database
DB_CONNECTION=pgsql
DB_HOST=pgsql
DB_PORT=5432
DB_DATABASE=servitel_db
DB_USERNAME=sail
DB_PASSWORD=password

# Redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Mail (optional)
MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525

# Sanctum
SANCTUM_STATEFUL_DOMAINS=localhost
```

### Available Sail Aliases

```bash
# Shortcuts for Sail commands
alias sail='./vendor/bin/sail'

sail up -d              # Start containers
sail down               # Stop containers
sail artisan <cmd>      # Run artisan commands
sail npm <cmd>          # Run npm commands
sail test               # Run tests
sail shell             # Enter container shell
```

## Database

### Migrations

```bash
# Run all migrations
sail artisan migrate

# Rollback last migration
sail artisan migrate:rollback

# Reset all migrations
sail artisan migrate:reset

# Drop all tables and re-run migrations
sail artisan migrate:fresh

# Seed the database
sail artisan db:seed

# Run migrations with seed
sail artisan migrate:fresh --seed
```

### Models

- **User** - User authentication and ownership
- **Task** - Task items with status, priority, and due dates
- **Weather** - Cached weather data from external API

## API Endpoints

All endpoints require authentication via Laravel Sanctum token.

### Tasks

| Method | Endpoint | Description | Auth |
|--------|----------|-------------|------|
| GET | `/api/tasks` | List all tasks (paginated) | Yes |
| GET | `/api/tasks/{id}` | Get single task | Yes |
| POST | `/api/tasks` | Create new task | Yes |
| PUT | `/api/tasks/{id}` | Update task | Yes |
| DELETE | `/api/tasks/{id}` | Delete task | Yes |

#### Query Parameters

- `?status=pending|in_progress|completed|cancelled` - Filter by status
- `?priority=1|2|3` - Filter by priority
- `?page=1` - Pagination

#### Request Examples

```bash
# Create task
curl -X POST http://localhost/api/tasks \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "My first task",
    "description": "Task description",
    "status": "pending",
    "priority": 2,
    "due_date": "2024-12-31"
  }'

# List tasks
curl http://localhost/api/tasks?status=pending \
  -H "Authorization: Bearer YOUR_TOKEN"

# Update task
curl -X PUT http://localhost/api/tasks/1 \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"title": "Updated title", "status": "completed"}'

# Delete task
curl -X DELETE http://localhost/api/tasks/1 \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### Authentication

```bash
# Login to get token (requires existing user)
curl -X POST http://localhost/api/login \
  -H "Content-Type: application/json" \
  -d '{"email": "user@example.com", "password": "password"}'

# Create token for user
php artisan sanctum:token
```

## Running the Project

### Development Server

```bash
# Using Sail
sail up -d

# Using Artisan
php artisan serve
```

### Docker Containers

```bash
# Start all containers
./vendor/bin/sail up -d

# View logs
./vendor/bin/sail logs -f

# Stop containers
./vendor/bin/sail down
```

### Available Services

- **Laravel**: `http://localhost`
- **PostgreSQL**: `localhost:5432`
- **Redis**: `localhost:6379`

## Weather Integration

The application integrates with [Open-Meteo API](https://open-meteo.com/) for weather data.

### Available Cities

- Bogotá
- Medellín
- Cúcuta

### Commands

```bash
# Fetch weather for a city
sail artisan weather:fetch Bogota Colombia

# This is also available via the Filament dashboard widget
```

### Widget

A weather widget is available on the Filament dashboard showing current weather conditions for configured cities.

## Testing

```bash
# Run all tests
sail test

# Run specific test file
sail test tests/Feature/TaskApiTest.php

# Run tests with coverage
sail test --coverage

# Run tests in compact mode
sail test --compact
```

### Test Coverage

- Task API CRUD operations
- Authentication middleware
- Validation rules
- Status filtering

## Features

- [x] RESTful API with Laravel
- [x] Token-based authentication (Sanctum)
- [x] Admin panel with Filament
- [x] Weather API integration (Open-Meteo)
- [x] Redis caching
- [x] Pagination and filters
- [x] Docker with Sail
- [x] Automated tests with Pest

## Project Structure

```
app/
├── Console/Commands/     # Artisan commands
├── Filament/           # Admin panel resources
│   ├── Resources/      # Task resource
│   └── Widgets/        # Weather widget
├── Http/Controllers/   # API controllers
├── Models/            # Eloquent models
└── Services/          # Business logic (WeatherService)

database/
├── factories/         # Model factories
├── migrations/        # Database migrations
└── seeders/          # Database seeders

routes/
├── api.php           # API routes
├── web.php           # Web routes
└── ai.php            # MCP routes

tests/
├── Feature/           # Feature tests
└── Unit/             # Unit tests
```

## License

MIT License
