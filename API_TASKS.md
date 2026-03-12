# API REST de Tasks - Documentación

## Autenticación

Esta API usa **Laravel Sanctum** para autenticación. Para usar los endpoints, debes incluir el token en el header:

```
Authorization: Bearer {tu_token_aqui}
```

### Obtener Token de Acceso

**POST** `/sanctum/token`

Body:
```json
{
  "email": "tu@email.com",
  "password": "tu_password"
}
```

Response:
```json
{
  "token": "token_generado"
}
```

---

## Endpoints

| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | `/api/tasks` | Listar todas las tareas del usuario |
| POST | `/api/tasks` | Crear una nueva tarea |
| GET | `/api/tasks/{id}` | Ver una tarea específica |
| PUT | `/api/tasks/{id}` | Actualizar una tarea |
| DELETE | `/api/tasks/{id}` | Eliminar una tarea |

---

## Ejemplos de Uso

### Listar tareas
```bash
curl -X GET http://localhost/api/tasks \
  -H "Authorization: Bearer {token}"
```

### Filtrar tareas
```bash
# Por estado
curl -X GET "http://localhost/api/tasks?status=pending" \
  -H "Authorization: Bearer {token}"

# Por prioridad
curl -X GET "http://localhost/api/tasks?priority=3" \
  -H "Authorization: Bearer {token}"
```

### Crear tarea
```bash
curl -X POST http://localhost/api/tasks \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Mi nueva tarea",
    "description": "Descripción opcional",
    "status": "pending",
    "priority": 2,
    "due_date": "2024-12-31",
    "tags": ["trabajo", "urgente"]
  }'
```

### Actualizar tarea
```bash
curl -X PUT http://localhost/api/tasks/1 \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "status": "completed"
  }'
```

### Eliminar tarea
```bash
curl -X DELETE http://localhost/api/tasks/1 \
  -H "Authorization: Bearer {token}"
```

---

## Códigos de Respuesta

| Código | Descripción |
|--------|-------------|
| 200 | OK - Solicitud exitosa |
| 201 | Created - Tarea creada exitosamente |
| 400 | Bad Request - Datos inválidos |
| 401 | Unauthorized - Token no válido o expirado |
| 404 | Not Found - Tarea no encontrada |
| 422 | Unprocessable Entity - Error de validación |

---

## Campos Disponibles

| Campo | Tipo | Requerido | Descripción |
|-------|------|-----------|-------------|
| `title` | string | Sí | Título de la tarea (max 255) |
| `description` | string | No | Descripción detallada |
| `status` | enum | No | pending, in_progress, completed, cancelled |
| `priority` | integer | No | 1=Baja, 2=Media, 3=Alta |
| `due_date` | date | No | Fecha de vencimiento (YYYY-MM-DD) |
| `tags` | array | No | Lista de etiquetas |

---

## Notas

- Cada usuario solo puede ver y modificar sus propias tareas
- Cuando una tarea se marca como `completed`, se guarda automáticamente la fecha en `completed_at`
- Las tareas eliminadas usan soft delete (no se borran permanentemente)
