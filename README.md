# Halcon - Backend

Este es el cliente backend para el proyecto Halcón, desarrollado en Laravel.

## Instalación

1. Clona el repositorio:
   ```bash
   git clone <url-del-repositorio>
   cd halcon
   ```
2. Instala las dependencias de PHP y Node:
   ```bash
   composer install
   npm install
   ```
3. Copia el archivo de entorno y genera la clave de la aplicación:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Configura tu base de datos en el archivo `.env` y ejecuta las migraciones:
   ```bash
   php artisan migrate --seed
   ```

## Variables de Entorno

Asegúrate de configurar las siguientes variables principales en tu archivo `.env`:

- `APP_NAME`: Nombre de la aplicación (ej. `Laravel`).
- `APP_ENV`: Entorno (ej. `local`, `production`).
- `APP_KEY`: Clave de la aplicación.
- `APP_DEBUG`: Habilita o deshabilita el modo debug (`true` o `false`).
- `APP_URL`: URL base de la aplicación (ej. `http://localhost`).
- `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`: Credenciales de la base de datos MySQL.
- `VITE_APP_NAME`: Nombre de la aplicación para Vite.

## Comandos

- Iniciar el servidor de desarrollo de Laravel:
  ```bash
  php artisan serve
  ```
- Iniciar el servidor de desarrollo de Vite (frontend assets):
  ```bash
  npm run dev
  ```
- Compilar assets para producción:
  ```bash
  npm run build
  ```

## Licencias

Este proyecto fue desarrollado con fines académicos como parte de la materia de Diseño de Aplicaciones Web.
