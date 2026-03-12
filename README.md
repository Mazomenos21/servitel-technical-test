# Servitel Technical Test

API REST Laravel para gestión de tareas con integración de clima.

## Instalación

```bash
# Instalar dependencias
composer install
npm install

# Configurar entorno
cp .env.example .env
# Editar .env con tus credenciales de DB

# Generar clave de aplicación
php artisan key:generate

# Ejecutar migraciones
php artisan migrate

# Ejecutar seeders (opcional)
php artisan db:seed
```

## Configuración

Variables de entorno requeridas en `.env`:

```
DB_CONNECTION=pgsql
DB_HOST=pgsql
DB_PORT=5432
DB_DATABASE=servitel-db
DB_USERNAME=root
DB_PASSWORD=password

REDIS_HOST=127.0.0.1
REDIS_PORT=6379
```

## Base de datos

```bash
# Migraciones
php artisan migrate

# Rollback
php artisan migrate:rollback

# Fresh con seed
php artisan migrate:fresh --seed
```

## Endpoints API

### Tareas (Task)

| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | `/api/tasks` | Listar tareas (paginado) |
| GET | `/api/tasks/{id}` | Ver tarea |
| POST | `/api/tasks` | Crear tarea |
| PUT | `/api/tasks/{id}` | Actualizar tarea |
| DELETE | `/api/tasks/{id}` | Eliminar tarea |

#### Filtros

- `?status=pending` - Filtrar por estado
- `?priority=3` - Filtrar por prioridad
- `?page=2` - Paginación

#### Ejemplo de request

```bash
# Autenticación
curl -H "Authorization: Bearer <TOKEN>" http://localhost/api/tasks

# Crear tarea
curl -X POST http://localhost/api/tasks \
  -H "Authorization: Bearer <TOKEN>" \
  -H "Content-Type: application/json" \
  -d '{"title": "Mi tarea", "description": "Descripción", "status": "pending", "priority": 2}'
```

## Ejecución del proyecto

```bash
# Servidor local
php artisan serve

# Con Docker
docker-compose up -d
```

## Panel de Administración

- URL: `/admin`
- Autenticación: Laravel Fortify

## Tests

```bash
# Ejecutar todos los tests
php artisan test

# Ejecutar tests específicos
php artisan test --filter=TaskApiTest
```

## Características

- API REST con Laravel Sanctum
- Panel de administración con Filament
- Integración con API de clima (Open-Meteo)
- Caché con Redis
- Paginación y filtros
- Tests automatizados con Pest
