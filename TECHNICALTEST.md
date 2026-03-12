# Prueba Técnica – Desarrollador Ingeniero Senior

**Proceso de selección – Evaluación práctica**

Este documento describe la **prueba técnica práctica** para los candidatos que aprobaron la evaluación teórica del
proceso de selección para la vacante de **Ing. Senior Desarrollador**.

El objetivo de esta prueba es evaluar las habilidades prácticas del candidato en:

- Desarrollo de APIs
- Arquitectura backend
- Buenas prácticas de programación
- Integración con APIs externas
- Uso de bases de datos
- Documentación técnica

---

## Tiempo de la prueba

El candidato dispone de **24 horas desde la recepción del correo** para completar la prueba.

La entrega debe realizarse enviando un **enlace a un repositorio público de Git** con el proyecto desarrollado.

No se aceptarán entregas fuera del tiempo establecido.

---

## Tecnologías permitidas

El candidato puede utilizar cualquiera de los siguientes frameworks:

- **Opción 1:** Laravel (PHP)
- **Opción 2:** Flask (Python)

### Base de datos

Debe utilizar una base de datos relacional:

- MySQL
- PostgreSQL

---

## Descripción del proyecto

El candidato debe desarrollar una **API REST** que permita gestionar un sistema simple.

Ejemplos de sistemas posibles:

- Sistema de tareas
- Sistema de productos
- Sistema de usuarios
- Sistema de notas

El sistema debe permitir realizar operaciones **CRUD completas** y además **consumir una API externa pública**.

---

## Funcionalidades requeridas

El proyecto debe incluir como mínimo:

### 1. API REST

Implementar los siguientes endpoints:

```
GET    /items
GET    /items/{id}
POST   /items
PUT    /items/{id}
DELETE /items/{id}
```

### 2. Integración con API externa

El sistema debe consumir al menos una API externa pública.

Ejemplos:

- API del clima
- API de películas
- API de datos públicos
- API de prueba como JSONPlaceholder

Se debe implementar al menos **un endpoint que consuma dicha API**.

### 3. Base de datos

El proyecto debe incluir:

- Migraciones de base de datos
- Modelos
- Persistencia de datos

### 4. Autenticación

El sistema debe incluir autenticación mediante token.

Opciones posibles:

- JWT
- Token simple
- Sistema de autenticación propio del framework

Al menos algunos endpoints deben requerir autenticación.

### 5. Validación de datos

Los datos enviados a la API deben ser validados.

Ejemplo:

- Campos obligatorios
- Tipos de datos
- Longitud mínima o máxima

### 6. Manejo de errores

La API debe responder correctamente con códigos HTTP apropiados:

| Código | Significado            |
|--------|------------------------|
| 200    | OK                     |
| 201    | Created                |
| 400    | Bad Request            |
| 401    | Unauthorized           |
| 404    | Not Found              |
| 500    | Internal Server Error  |

### 7. Repositorio Git

El proyecto debe ser entregado mediante un repositorio público en:

- GitHub
- GitLab

El repositorio debe incluir:

- Historial de commits
- Código organizado
- README

---

## Documentación requerida

El proyecto debe incluir un archivo `README.md` con la siguiente información:

| Sección | Descripción |
|---------|-------------|
| **Instalación del proyecto** | Pasos para instalar y ejecutar el sistema |
| **Configuración** | Variables de entorno necesarias |
| **Base de datos** | Cómo ejecutar migraciones |
| **Endpoints** | Listado de endpoints disponibles |
| **Ejecución del proyecto** | Cómo iniciar el servidor |
| **Tests (si existen)** | Cómo ejecutar las pruebas |

---

## Extras que suman puntos (Opcionales)

Los siguientes elementos **no son obligatorios**, pero suman puntos en la evaluación:

- Uso de Docker
- Uso de Docker Compose
- Implementación de caché
- Paginación en endpoints
- Filtros de búsqueda
- Tests automatizados
- Documentación de API (Swagger o similar)

---

## Estructura esperada del proyecto

Se espera una estructura clara y organizada del código:

```
app/
├── Controllers/
├── Models/
├── Services/
├── Repositories/
routes/
migrations/
```

Se valorará la correcta **separación de responsabilidades**.

---

## Rúbrica de evaluación

| Criterio | Descripción | Peso |
|----------|-------------|------|
| Arquitectura del proyecto | Organización del código y separación de responsabilidades | 20% |
| Calidad del código | Legibilidad, buenas prácticas y mantenibilidad | 20% |
| Diseño de la API | Correcto uso de REST y códigos HTTP | 20% |
| Integración con API externa | Correcta implementación del consumo de API | 15% |
| Base de datos | Uso adecuado de modelos, migraciones y relaciones | 10% |
| Documentación | Claridad del README y documentación de endpoints | 10% |
| Testing | Implementación de pruebas automatizadas | 5% |

---

## Entrega

El candidato debe enviar:

1. Enlace al repositorio Git público
2. Código completo del proyecto
3. README con documentación

La entrega debe realizarse **dentro del plazo de 24 horas desde la recepción del correo**.

---

## Observaciones

El código debe ser **funcional y ejecutable**.

Se evaluará especialmente:

- Claridad del código
- Buenas prácticas
- Organización del proyecto
- Documentación