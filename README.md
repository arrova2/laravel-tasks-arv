# Tasks API – Laravel 9

API básica de **Usuarios y Tareas** con Laravel 9.

## Requerimientos
- PHP 8.0+  
- Composer  
- SQLite (recomendado para pruebas rápidas) o MySQL

## Setup rápido
```bash
# 1) Instalar dependencias
composer install

# 2) Variables de entorno
cp .env.example .env
php artisan key:generate

# 3) Para las pruebas 
php artisan test
