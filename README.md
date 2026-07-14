# NEREA STUDIO — Proyecto Web Peluquería

Sistema web para gestión de turnos de una peluquería, desarrollado con **Laravel + Livewire**.

**Carrera:** Analista de Sistemas — **Materia:** Producción Web — **Comisión:** ACN3BV
**Alumnos:** Juan Manuel Cappi, Santiago Gómez Pereyra, Jonathan Gennari

---

## Requisitos previos

- PHP >= 8.2
- Composer
- Node.js y npm
- MySQL (o el motor configurado en `.env`)

---

## Instalación paso a paso

### 1. Clonar el repositorio

```bash
git clone https://github.com/Genj32/Nerea-TP2.git
cd Proyecto-Web-Peluqueria
```

### 2. Instalar dependencias de PHP

```bash
composer install
```

### 3. Instalar dependencias de JavaScript

```bash
npm install
```

### 4. Configurar el entorno

Copiar el archivo de ejemplo y generar la clave de la aplicación:

```bash
cp .env.example .env
php artisan key:generate
```

Abrir el archivo `.env` y configurar los datos de conexión a la base de datos:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nerea_studio
DB_USERNAME=root
DB_PASSWORD=
```

> Importante: crear antes la base de datos vacía (por ejemplo `nerea_studio`) desde MySQL o phpMyAdmin. Laravel no crea la base en sí, solo las tablas.

```sql
CREATE DATABASE nerea_studio;
```

### 5. Ejecutar las migraciones

Este comando crea automáticamente todas las tablas del sistema (usuarios, roles, profesionales, recepcionistas, turnos, especialidades, servicios, etc.):

```bash
php artisan migrate
```

Si en algún momento necesitás borrar todas las tablas y volver a crearlas desde cero:

```bash
php artisan migrate:fresh
```

### 6. Cargar los datos de prueba (seeders)

Este paso crea los **tres roles del sistema** (admin, recepcionista, cliente) y un usuario de prueba para cada uno, además de servicios y especialidades base:

```bash
php artisan db:seed
```

O ambos pasos juntos :

```bash
php artisan migrate:fresh --seed
```

### 7. Compilar los assets (CSS/JS)

```bash
npm run build
```

Para desarrollo, con recarga en caliente:

```bash
npm run dev
```

### 8. Levantar el servidor local

```bash
php artisan serve
```

La aplicación quedará disponible en `http://127.0.0.1:8000`.

---

## Usuarios de prueba (cargados por el seeder)

| Rol            | Email                  | Contraseña   |
|----------------|-------------------------|--------------|
| Administrador  | nerea@gmail.com         | artemis123   |
| Recepcionista  | recepcion@gmail.com     | artemis123   |
| Cliente        | cliente@gmail.com       | artemis123   |

---

## Comandos útiles adicionales

```bash
# Ver el estado de las migraciones
php artisan migrate:status

# Revertir la última tanda de migraciones
php artisan migrate:rollback

# Limpiar cachés (útil si hay cambios raros de configuración o rutas)
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

## Roles y accesos del sistema

- **Administrador:** gestiona profesionales, recepcionistas, especialidades y servicios (CRUD completo). Ruta protegida por middleware `admin`.
- **Recepcionista:** gestiona los turnos del salón desde su panel propio. Ruta protegida por middleware `recepcionista`.
- **Cliente:** reserva turnos, y edita o cancela sus propios turnos desde su perfil.

Todas las rutas administrativas y de recepción están protegidas mediante middlewares (`IsAdmin`, `IsRecepcionista`), por lo que un usuario sin el rol correspondiente no puede acceder a ellas ni siquiera pegando la URL manualmente en el navegador.
