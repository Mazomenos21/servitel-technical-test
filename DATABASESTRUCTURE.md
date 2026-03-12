# 🗄️ Estructura de Base de Datos — Sistema de Gestión de Tareas

> **Stack:** Laravel 11 + PostgreSQL + Laravel Sanctum  
> **Patrón:** Un usuario puede tener muchas tareas (One-to-Many)

---

## Tablas

### `users`

> Generada por Laravel. Sanctum la extiende con `personal_access_tokens`.

| Columna            | Tipo               | Restricciones                  | Descripción                        |
|--------------------|--------------------|--------------------------------|------------------------------------|
| `id`               | `BIGINT`           | PK, AUTO INCREMENT             | Identificador único del usuario    |
| `name`             | `VARCHAR(255)`     | NOT NULL                       | Nombre completo                    |
| `email`            | `VARCHAR(255)`     | NOT NULL, UNIQUE               | Correo electrónico (login)         |
| `email_verified_at`| `TIMESTAMP`        | NULLABLE                       | Fecha de verificación de email     |
| `password`         | `VARCHAR(255)`     | NOT NULL                       | Hash bcrypt de la contraseña       |
| `remember_token`   | `VARCHAR(100)`     | NULLABLE                       | Token para "recuérdame"            |
| `created_at`       | `TIMESTAMP`        | NULLABLE                       | Fecha de creación                  |
| `updated_at`       | `TIMESTAMP`        | NULLABLE                       | Fecha de última actualización      |

**Índices:**

- `PRIMARY KEY (id)`
- `UNIQUE INDEX (email)`

---

### `personal_access_tokens`

> Generada automáticamente por Laravel Sanctum.

| Columna          | Tipo           | Restricciones      | Descripción                                      |
|------------------|----------------|--------------------|--------------------------------------------------|
| `id`             | `BIGINT`       | PK, AUTO INCREMENT | Identificador del token                          |
| `tokenable_type` | `VARCHAR(255)` | NOT NULL           | Clase del modelo dueño (ej: `App\Models\User`)   |
| `tokenable_id`   | `BIGINT`       | NOT NULL           | ID del modelo dueño                              |
| `name`           | `VARCHAR(255)` | NOT NULL           | Nombre descriptivo del token (ej: `"api-token"`) |
| `token`          | `VARCHAR(64)`  | NOT NULL, UNIQUE   | Hash SHA-256 del token                           |
| `abilities`      | `TEXT`         | NULLABLE           | JSON con habilidades (scopes) del token          |
| `last_used_at`   | `TIMESTAMP`    | NULLABLE           | Último uso del token                             |
| `expires_at`     | `TIMESTAMP`    | NULLABLE           | Fecha de expiración (null = no expira)           |
| `created_at`     | `TIMESTAMP`    | NULLABLE           | Fecha de creación                                |
| `updated_at`     | `TIMESTAMP`    | NULLABLE           | Fecha de última actualización                    |

**Índices:**

- `PRIMARY KEY (id)`
- `UNIQUE INDEX (token)`
- `INDEX (tokenable_type, tokenable_id)` — polimorfismo

---

### `tasks`

> Tabla principal del sistema. Pertenece a un `user`.

| Columna        | Tipo            | Restricciones                              | Descripción                                              |
|----------------|-----------------|--------------------------------------------|----------------------------------------------------------|
| `id`           | `BIGINT`        | PK, AUTO INCREMENT                         | Identificador único de la tarea                          |
| `user_id`      | `BIGINT`        | NOT NULL, FK → `users.id`                  | Propietario de la tarea                                  |
| `title`        | `VARCHAR(255)`  | NOT NULL                                   | Título descriptivo de la tarea                           |
| `description`  | `TEXT`          | NULLABLE                                   | Descripción detallada                                    |
| `status`       | `VARCHAR(20)`   | NOT NULL, DEFAULT `'pending'`              | Estado actual: `pending`, `in_progress`, `completed`, `cancelled` |
| `priority`     | `SMALLINT`      | NOT NULL, DEFAULT `2`                      | Prioridad: `1`=baja, `2`=media, `3`=alta                 |
| `due_date`     | `DATE`          | NULLABLE                                   | Fecha de vencimiento de la tarea                         |
| `tags`         | `JSONB`         | NULLABLE, DEFAULT `'[]'`                   | Etiquetas como array JSON (ej: `["urgente","cliente"]`)  |
| `metadata`     | `JSONB`         | NULLABLE, DEFAULT `'{}'`                   | Datos extra extensibles sin alterar el schema            |
| `completed_at` | `TIMESTAMP`     | NULLABLE                                   | Fecha real en que se completó la tarea                   |
| `deleted_at`   | `TIMESTAMP`     | NULLABLE                                   | Soft delete — null = activa                              |
| `created_at`   | `TIMESTAMP`     | NULLABLE                                   | Fecha de creación                                        |
| `updated_at`   | `TIMESTAMP`     | NULLABLE                                   | Fecha de última actualización                            |

**Índices:**

- `PRIMARY KEY (id)`
- `INDEX (user_id, status)` — consulta más frecuente: tareas de un usuario por estado
- `INDEX (user_id, due_date)` — para ordenar por vencimiento
- `INDEX (user_id, deleted_at)` — optimiza soft deletes en scopes
- `GIN INDEX (tags)` — permite buscar dentro del array JSONB de etiquetas

**Clave foránea:**

```sql
CONSTRAINT fk_tasks_user
  FOREIGN KEY (user_id) REFERENCES users(id)
  ON DELETE CASCADE
```

---

## Diagrama de Relaciones (ERD simplificado)

```
┌─────────────────────┐          ┌──────────────────────────────────────┐
│        users        │          │               tasks                  │
├─────────────────────┤          ├──────────────────────────────────────┤
│ id          (PK)    │◄────┐    │ id             (PK)                  │
│ name                │     │    │ user_id         (FK) ────────────────┘
│ email       (UQ)    │     └────│ title                                │
│ password            │          │ description                          │
│ created_at          │          │ status          [pending|in_progress  │
│ updated_at          │          │                  completed|cancelled] │
└─────────────────────┘          │ priority        [1|2|3]              │
                                 │ due_date                             │
┌─────────────────────┐          │ tags            (JSONB)              │
│ personal_access_    │          │ metadata        (JSONB)              │
│ tokens              │          │ completed_at                         │
├─────────────────────┤          │ deleted_at      (SoftDelete)         │
│ id          (PK)    │          │ created_at                           │
│ tokenable_type      │          │ updated_at                           │
│ tokenable_id  ──────┼──────►  └──────────────────────────────────────┘
│ name                │  (users.id)
│ token       (UQ)    │
│ abilities           │
│ expires_at          │
└─────────────────────┘
```

---

## Relaciones Eloquent

| Modelo | Relación      | Modelo relacionado | Método          |
|--------|---------------|--------------------|-----------------|
| `User` | `hasMany`     | `Task`             | `user->tasks()` |
| `Task` | `belongsTo`   | `User`             | `task->user()`  |

---

## Valores permitidos para campos enum-like

### `status`

| Valor         | Descripción              |
|---------------|--------------------------|
| `pending`     | Tarea creada, sin iniciar |
| `in_progress` | En progreso actualmente  |
| `completed`   | Finalizada exitosamente  |
| `cancelled`   | Cancelada                |

### `priority`

| Valor | Etiqueta |
|-------|----------|
| `1`   | Baja     |
| `2`   | Media    |
| `3`   | Alta     |

---

## Notas sobre tipos de dato PostgreSQL

### `JSONB` vs `JSON`

Se eligió **`JSONB`** (Binary JSON) en lugar de `JSON` plano por tres razones:

1. **Indexable** con `GIN INDEX`, permitiendo queries como `tags @> '["urgente"]'`
2. **Más rápido en lectura** — almacena en formato binario parseado
3. **Elimina duplicados** y normaliza el orden de keys automáticamente

### `SMALLINT` para `priority`

Ocupa solo 2 bytes vs 4 de `INTEGER`. Para valores acotados (1-3) es la elección correcta y demuestra criterio en el
diseño del schema.

### `DATE` para `due_date`

Se usa `DATE` en lugar de `TIMESTAMP` porque la fecha de vencimiento de una tarea no requiere hora exacta. Simplifica
validaciones y comparaciones.

---

## Orden de Migraciones (Laravel)

```
2014_10_12_000000_create_users_table.php
2014_10_12_100000_create_password_reset_tokens_table.php
2019_12_14_000001_create_personal_access_tokens_table.php   ← Sanctum
2024_01_01_000001_create_tasks_table.php
```

> **Comando para ejecutar:**
> ```bash
> ./vendor/bin/sail artisan migrate --seed
> ```