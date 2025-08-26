# Tasks API – Laravel 9# Tasks API (Laravel 9)

API sencilla para gestionar **Usuarios** y **Tareas**. Hecha con Laravel 9 pensando en claridad y rapidez para correrla localmente.

## Requisitos
- PHP 8.0+
- Composer
- SQLite (recomendado para pruebas rápidas) o MySQL
- cURL o algún cliente tipo Thunder/Insomnia/Postman

---

## Arranque rápido

```bash
# 1) Instalar dependencias
composer install

# 2) Variables de entorno
cp .env.example .env
php artisan key:generate
```

### Base de datos (SQLite)
Crea el archivo de la base:

type nul > database\database.sqlite
```

Editar `.env` y dejar estos valores (ajusta la ruta absoluta):
```
DB_CONNECTION=sqlite
DB_DATABASE=/ruta/absoluta/al/proyecto/database/database.sqlite
API_TOKEN=secreto-super
```

Luego correr las migraciones:
```bash
php artisan migrate
```

### Correr el servidor
```bash
php artisan serve
# http://127.0.0.1:8000
```
> Tip: si el puerto está ocupado o el server no responde, probar:
> `php artisan serve --host=127.0.0.1 --port=8081`  
> o `php -S 127.0.0.1:8000 -t public`

---

## Endpoints

**GET** `/api/users`  
Lista todos los usuarios.

**GET** `/api/users/{id}/tasks`  
Lista todas las tareas de un usuario.

> Los siguientes requieren **token** en el header  
> `Authorization: Bearer {API_TOKEN}`

**POST** `/api/tasks`  
Crea una tarea.
```json
{
  "title": "Tarea importante",
  "description": "Descripción breve",
  "status": "pending",
  "user_id": 1
}
```

**PUT** `/api/tasks/{id}`  
Actualiza cualquiera de: `title`, `description`, `status`.

**DELETE** `/api/tasks/{id}`  
Elimina una tarea.

### Validaciones
- `title`: requerido, mínimo **5** caracteres  
- `description`: opcional, máximo **500**  
- `status`: `pending | in_progress | completed`  
- `user_id`: debe existir en `users.id`

---

## Testing

Este proyecto incluye 3 pruebas con PHPUnit:

1. Crear una tarea correctamente (201)  
2. Rechazar creación con datos inválidos (422)  
3. Eliminar una tarea (200)

### Configurar entorno de pruebas

Crea `/.env.testing` con lo básico (usa tu propia llave o copia la de `.env`):

```
APP_ENV=testing
APP_KEY=base64:TU_LLAVE_AQUI
API_TOKEN=secreto-super

DB_CONNECTION=sqlite
DB_DATABASE=:memory:
APP_URL=http://localhost
```

Limpia cachés y corre:
```bash
php artisan optimize:clear
php artisan test
```

# Git
Les dejo por este medio la ruta de git para descargar el proyecto o hacer fork:
```bash
https://github.com/arrova2/laravel-tasks-arv
```
