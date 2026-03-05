# 🚗 VIP2CARS — Sistema de Gestión de Vehículos

> CRUD de vehículos y contactos para el taller automotriz **VIP2CARS**, desarrollado con Laravel 11.

---

## 📋 Tabla de Contenidos

- [Descripción](#-descripción)
- [Requisitos del entorno](#-requisitos-del-entorno)
- [Instalación y configuración](#-instalación-y-configuración)
- [Puesta en marcha](#-puesta-en-marcha)
- [Credenciales demo](#-credenciales-demo)
- [Estructura de la base de datos](#-estructura-de-la-base-de-datos)
- [Funcionalidades](#-funcionalidades)
- [Estructura del proyecto](#-estructura-del-proyecto)

---

## 📌 Descripción

Sistema web desarrollado en **Laravel 11** que permite gestionar el registro de vehículos y sus propietarios. Incluye autenticación, CRUD completo con validaciones, búsqueda, paginación y manejo de errores.

---

## 🔧 Requisitos del entorno

| Requisito | Versión mínima |
|-----------|---------------|
| PHP | **8.2** o superior |
| Laravel | **11.x** |
| Composer | **2.x** |
| MySQL | **8.0** o superior (también compatible con MariaDB 10.4+) |
| Node.js | **18.x** o superior |
| NPM | **9.x** o superior |

### Extensiones PHP requeridas

Estas extensiones deben estar habilitadas en tu `php.ini`:

```
extension=pdo_mysql
extension=mbstring
extension=openssl
extension=tokenizer
extension=xml
extension=ctype
extension=json
extension=bcmath
extension=fileinfo
```

> 💡 Si usas **XAMPP**, **Laragon** o **WAMP**, estas extensiones ya vienen habilitadas por defecto.

---

## 🧰 Instalación y configuración

### 1. Clonar el repositorio

```bash
git clone https://github.com/tu-usuario/vip2cars.git
cd vip2cars
```

### 2. Instalar dependencias PHP

```bash
composer install
```

### 3. Instalar dependencias de Node.js

```bash
npm install
```

### 4. Configurar variables de entorno

Copia el archivo de ejemplo y edítalo con tus datos:

```bash
cp .env.example .env
```

Luego abre el `.env` y configura tu base de datos:

```env
APP_NAME=VIP2CARS
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=vip2cars      # ← nombre de tu base de datos
DB_USERNAME=root           # ← tu usuario de MySQL
DB_PASSWORD=               # ← tu contraseña de MySQL
```

### 5. Generar la clave de la aplicación

```bash
php artisan key:generate
```

### 6. Crear la base de datos

Antes de migrar, crea la base de datos en MySQL:

```sql
CREATE DATABASE vip2cars CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

O desde tu gestor (phpMyAdmin, TablePlus, DBeaver, etc.) crea una base de datos llamada `vip2cars`.

---

## ▶️ Puesta en marcha

### 7. Ejecutar las migraciones

```bash
php artisan migrate
```

### 8. Ejecutar los seeders (datos de prueba)

```bash
php artisan db:seed
```

Esto creará:
- ✅ **1 usuario administrador** (ver credenciales abajo)
- ✅ **12 vehículos de prueba** con datos realistas

### 9. Compilar los assets

```bash
npm run build
```

> Para desarrollo con recarga automática usa `npm run dev` en lugar de `npm run build`.

### 10. Levantar el servidor

```bash
php artisan serve
```

Abre tu navegador en: **http://localhost:8000**

---

## 🔑 Credenciales demo

Una vez que corras los seeders, podrás ingresar con:

| Campo | Valor |
|-------|-------|
| **Email** | `admin@vip2cars.com` |
| **Contraseña** | `vip2cars2026` |

---

## 🗄️ Estructura de la base de datos

### Tabla `vehiculos`

| Columna | Tipo | Descripción |
|---------|------|-------------|
| `id` | BIGINT UNSIGNED | Clave primaria, autoincremental |
| `placa` | VARCHAR(20) | Placa del vehículo — única |
| `marca` | VARCHAR(100) | Marca del vehículo |
| `modelo` | VARCHAR(100) | Modelo del vehículo |
| `anio_fabricacion` | YEAR | Año de fabricación |
| `nombre_cliente` | VARCHAR(100) | Nombre del propietario |
| `apellidos_cliente` | VARCHAR(150) | Apellidos del propietario |
| `nro_documento` | VARCHAR(20) | DNI / RUC / Pasaporte — único |
| `correo_cliente` | VARCHAR(255) | Correo electrónico — único |
| `telefono_cliente` | VARCHAR(20) | Teléfono o celular |
| `created_at` | TIMESTAMP | Fecha de creación |
| `updated_at` | TIMESTAMP | Fecha de última actualización |

### Tabla `users` (autenticación)

| Columna | Tipo | Descripción |
|---------|------|-------------|
| `id` | BIGINT UNSIGNED | Clave primaria |
| `name` | VARCHAR(255) | Nombre del usuario |
| `email` | VARCHAR(255) | Correo — único |
| `password` | VARCHAR(255) | Contraseña hasheada (bcrypt) |
| `created_at` | TIMESTAMP | Fecha de creación |
| `updated_at` | TIMESTAMP | Fecha de actualización |

### Script SQL equivalente

```sql
CREATE TABLE vehiculos (
    id               BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    placa            VARCHAR(20)  NOT NULL UNIQUE,
    marca            VARCHAR(100) NOT NULL,
    modelo           VARCHAR(100) NOT NULL,
    anio_fabricacion YEAR         NOT NULL,
    nombre_cliente   VARCHAR(100) NOT NULL,
    apellidos_cliente VARCHAR(150) NOT NULL,
    nro_documento    VARCHAR(20)  NOT NULL UNIQUE,
    correo_cliente   VARCHAR(255) NOT NULL UNIQUE,
    telefono_cliente VARCHAR(20)  NOT NULL,
    created_at       TIMESTAMP NULL DEFAULT NULL,
    updated_at       TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

> El script completo de la base de datos también se puede generar con `php artisan migrate`.

---

## ✅ Funcionalidades

- 🔐 **Autenticación** — Login y logout con Laravel Breeze
- 📋 **Listado** de vehículos con paginación (10 por página)
- 🔍 **Búsqueda** por placa, marca, modelo, nombre, documento o correo
- ➕ **Crear** nuevo vehículo con validaciones completas en español
- ✏️ **Editar** registro existente
- 👁️ **Ver detalle** completo del vehículo y su propietario
- 🗑️ **Eliminar** con modal de confirmación
- ⚠️ **Manejo de errores** con páginas personalizadas (403, 404, 500)
- 🌱 **Seeders** con 12 registros de prueba y usuario demo

---

## 📁 Estructura del proyecto

```
app/
├── Http/
│   └── Controllers/
│       ├── Auth/
│       │   └── AuthenticatedSessionController.php
│       └── VehiculoController.php
└── Models/
    └── Vehiculo.php

database/
├── migrations/
│   └── ..._create_vehiculos_table.php
└── seeders/
    ├── DatabaseSeeder.php
    ├── UserSeeder.php
    └── VehiculoSeeder.php

resources/views/
├── auth/
│   └── login.blade.php
├── errors/
│   ├── 403.blade.php
│   ├── 404.blade.php
│   └── 500.blade.php
├── layouts/
│   └── app.blade.php
└── vehiculos/
    ├── _form.blade.php
    ├── create.blade.php
    ├── edit.blade.php
    ├── index.blade.php
    └── show.blade.php

routes/
├── web.php
└── auth.php
```

---

## 🛠️ Comandos útiles de referencia

```bash
# Ver todas las rutas registradas
php artisan route:list

# Revertir y volver a migrar con seeders
php artisan migrate:fresh --seed

# Limpiar caché de configuración
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

---

*Desarrollado con Laravel 11 · PHP 8.2 · MySQL 8 · Bootstrap 5*
