# 📊 Sistema de Encuestas Anónimas — Modelo de Base de Datos

> Diseño relacional para un sistema de encuestas donde los participantes responden de forma completamente anónima, sin necesidad de registrarse ni identificarse.

---

## 📋 Tabla de Contenidos

- [Visión general](#-visión-general)
- [Diagrama de relaciones](#-diagrama-de-relaciones)
- [Tablas y su justificación](#-tablas-y-su-justificación)
- [Relaciones entre tablas](#-relaciones-entre-tablas)
- [¿Cómo se garantiza el anonimato?](#-cómo-se-garantiza-el-anonimato)
- [Tipos de preguntas soportados](#-tipos-de-preguntas-soportados)
- [Vistas incluidas](#-vistas-incluidas)
- [Cómo ejecutar el script](#-cómo-ejecutar-el-script)

---

## 🧭 Visión general

El sistema está compuesto por **6 tablas** que trabajan en conjunto para permitir:

1. Que un **administrador** cree encuestas con preguntas y opciones de respuesta.
2. Que cualquier persona responda sin registrarse, usando un **token anónimo** (UUID).
3. Que el sistema pueda **detectar respuestas duplicadas** sin comprometer la identidad del participante.

---

## 🗺️ Diagrama de relaciones

```
users ──────────────────────── surveys
(administradores)               (encuestas)
                                    │
                          ┌─────────┴─────────┐
                          │                   │
                       questions           responses
                       (preguntas)         (sesiones anónimas)
                          │                   │
                       options             answers
                       (opciones)          (respuestas individuales)
                          │                   │
                          └───────────────────┘
                              (answers referencia
                               tanto question como option)
```

---

## 🗄️ Tablas y su justificación

### 1. `users` — Administradores del sistema

```sql
CREATE TABLE users (
    id            BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name          VARCHAR(100)  NOT NULL,
    email         VARCHAR(150)  NOT NULL,
    password_hash VARCHAR(255)  NOT NULL,
    role          ENUM('admin', 'editor', 'viewer') NOT NULL DEFAULT 'editor',
    ...
    UNIQUE KEY uq_users_email (email)
);
```

**¿Por qué existe esta tabla?**
Porque alguien tiene que *crear y administrar* las encuestas. Esta tabla **no representa a los participantes** — los participantes son anónimos y no se registran en ninguna tabla. Aquí solo viven los usuarios internos (administradores, editores) que gestionan el sistema.

El campo `role` permite tres niveles de acceso:
- `admin` → acceso total
- `editor` → puede crear y editar encuestas
- `viewer` → solo puede ver resultados

---

### 2. `surveys` — Encuestas

```sql
CREATE TABLE surveys (
    id           BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    created_by   BIGINT UNSIGNED NOT NULL,   -- quién la creó
    title        VARCHAR(200)  NOT NULL,
    description  TEXT,
    status       ENUM('draft', 'active', 'closed') NOT NULL DEFAULT 'draft',
    is_anonymous BOOLEAN       NOT NULL DEFAULT TRUE,
    starts_at    DATETIME,
    ends_at      DATETIME,
    ...
);
```

**¿Por qué existe esta tabla?**
Es el núcleo del sistema. Cada encuesta tiene un ciclo de vida controlado por el campo `status`:
- `draft` → en construcción, no visible para participantes
- `active` → abierta para recibir respuestas
- `closed` → cerrada, solo consulta de resultados

El campo `is_anonymous` permite que en el futuro el sistema soporte también encuestas **no anónimas** sin cambiar la estructura de la base de datos.

Los campos `starts_at` y `ends_at` permiten programar cuándo una encuesta está disponible automáticamente.

---

### 3. `questions` — Preguntas de la encuesta

```sql
CREATE TABLE questions (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    survey_id   BIGINT UNSIGNED NOT NULL,   -- a qué encuesta pertenece
    text        TEXT          NOT NULL,
    type        ENUM('single', 'multiple', 'text', 'scale', 'boolean') NOT NULL,
    is_required BOOLEAN       NOT NULL DEFAULT FALSE,
    `order`     SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    ...
);
```

**¿Por qué existe esta tabla?**
Porque una encuesta tiene múltiples preguntas, y cada pregunta puede ser de un **tipo distinto**. Separar las preguntas en su propia tabla permite agregar, editar u ordenar preguntas de forma independiente sin afectar la encuesta completa.

El campo `order` define el orden de aparición de las preguntas en el formulario. El campo `is_required` controla si el participante puede saltarse la pregunta o no.

---

### 4. `options` — Opciones de respuesta

```sql
CREATE TABLE options (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    question_id BIGINT UNSIGNED NOT NULL,   -- a qué pregunta pertenece
    text        VARCHAR(300)  NOT NULL,
    `order`     SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    ...
);
```

**¿Por qué existe esta tabla?**
Las preguntas de tipo `single` (una sola opción) y `multiple` (varias opciones) necesitan un catálogo de alternativas posibles. Esta tabla almacena esas alternativas vinculadas a su pregunta.

Las preguntas de tipo `text`, `scale` o `boolean` **no usan esta tabla** porque sus respuestas se almacenan directamente en `answers`.

---

### 5. `responses` — Sesión de respuesta anónima

```sql
CREATE TABLE responses (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    survey_id       BIGINT UNSIGNED NOT NULL,
    anonymous_token CHAR(36)      NOT NULL,  -- UUID v4 único por sesión
    ip_hash         VARCHAR(64)   NULL,       -- SHA-256 de la IP (solo para duplicados)
    submitted_at    TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    ...
    UNIQUE KEY uq_responses_token (anonymous_token)
);
```

**¿Por qué existe esta tabla?**
Esta tabla es la clave del anonimato. Representa **una sesión completa de respuesta** — es decir, el momento en que alguien entra a responder la encuesta.

En lugar de guardar quién respondió, se genera un **UUID aleatorio** (`anonymous_token`) que actúa como identificador temporal de esa sesión. Este UUID no tiene relación con ninguna persona, correo o cuenta.

El campo `ip_hash` guarda el hash SHA-256 de la IP del participante únicamente para **evitar respuestas duplicadas**, pero no permite identificar a la persona (un hash es irreversible).

> ⚠️ Nótese lo que **no está** en esta tabla: no hay `user_id`, no hay `email`, no hay `name`. El anonimato es estructural, no solo intencional.

---

### 6. `answers` — Respuestas individuales por pregunta

```sql
CREATE TABLE answers (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    response_id BIGINT UNSIGNED NOT NULL,   -- a qué sesión pertenece
    question_id BIGINT UNSIGNED NOT NULL,   -- qué pregunta responde
    option_id   BIGINT UNSIGNED NULL,       -- para tipo single/multiple
    text_value  TEXT            NULL,       -- para tipo text
    scale_value TINYINT         NULL,       -- para tipo scale (ej. 1-10)
    ...
);
```

**¿Por qué existe esta tabla?**
Mientras `responses` representa la sesión completa, `answers` representa **cada respuesta individual** dentro de esa sesión. Una sesión puede tener tantos registros en `answers` como preguntas tenga la encuesta.

Los tres campos opcionales (`option_id`, `text_value`, `scale_value`) permiten almacenar respuestas de distinto tipo en una sola tabla:
- Pregunta `single` o `multiple` → se usa `option_id`
- Pregunta `text` → se usa `text_value`
- Pregunta `scale` → se usa `scale_value`
- Pregunta `boolean` → se usa `option_id` con opciones "Sí" / "No"

Solo uno de estos tres campos tendrá valor en cada registro; los demás quedarán en `NULL`.

---

## 🔗 Relaciones entre tablas

| Tabla origen | Tabla destino | Tipo | Descripción |
|---|---|---|---|
| `surveys` | `users` | Muchos a uno | Una encuesta es creada por un usuario |
| `questions` | `surveys` | Muchos a uno | Una encuesta tiene muchas preguntas |
| `options` | `questions` | Muchos a uno | Una pregunta tiene muchas opciones |
| `responses` | `surveys` | Muchos a uno | Una encuesta recibe muchas sesiones de respuesta |
| `answers` | `responses` | Muchos a uno | Una sesión tiene muchas respuestas individuales |
| `answers` | `questions` | Muchos a uno | Cada respuesta pertenece a una pregunta |
| `answers` | `options` | Muchos a uno (nullable) | Una respuesta puede apuntar a una opción elegida |

### Comportamiento en cascada

| Relación | Al eliminar padre | Motivo |
|---|---|---|
| `surveys` → `questions` | `CASCADE` | Si se borra la encuesta, sus preguntas no tienen sentido |
| `questions` → `options` | `CASCADE` | Si se borra la pregunta, sus opciones tampoco |
| `surveys` → `responses` | `CASCADE` | Si se borra la encuesta, las respuestas se eliminan |
| `responses` → `answers` | `CASCADE` | Si se borra la sesión, sus respuestas individuales también |
| `answers` → `options` | `SET NULL` | Si se borra una opción, la respuesta queda pero sin referencia a opción |
| `surveys` → `users` | `RESTRICT` | No se puede borrar un usuario que tenga encuestas activas |

---

## 🔒 ¿Cómo se garantiza el anonimato?

El anonimato se garantiza a nivel **estructural** mediante tres decisiones de diseño:

**1. Sin `user_id` en `responses`**
La tabla de sesiones de respuesta no tiene ningún campo que vincule al participante con un usuario registrado. Es imposible saber quién respondió porque ese dato nunca se guarda.

**2. Token UUID aleatorio**
Cada sesión genera un UUID v4 (`xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx`) aleatorio en el momento de responder. Este token no contiene información personal y no es reversible.

**3. IP hasheada, no almacenada**
Si se desea evitar que la misma persona responda dos veces, se puede guardar el hash SHA-256 de su IP. Un hash es una función de una sola vía: se puede comparar para detectar duplicados, pero **no se puede revertir** para obtener la IP original.

```
IP real:   192.168.1.100
SHA-256:   b6d767d2f8ed5d21a44b0e5886680cb9...  ← solo esto se guarda
```

---

## 📐 Tipos de preguntas soportados

| Tipo | Descripción | Campo usado en `answers` |
|---|---|---|
| `single` | Una sola opción de una lista | `option_id` |
| `multiple` | Varias opciones de una lista | `option_id` (un registro por opción elegida) |
| `text` | Respuesta abierta en texto libre | `text_value` |
| `scale` | Escala numérica (ej. del 1 al 10) | `scale_value` |
| `boolean` | Sí / No | `option_id` con opciones predefinidas |

---

## 👁️ Vistas incluidas

### `v_survey_summary` — Resumen por encuesta
Muestra cuántas respuestas ha recibido cada encuesta, y cuándo fue la primera y última respuesta.

```sql
SELECT * FROM v_survey_summary;
```

### `v_option_counts` — Conteo por opción
Muestra cuántas veces fue seleccionada cada opción de cada pregunta. Útil para generar gráficas de resultados.

```sql
SELECT * FROM v_option_counts WHERE survey_id = 1;
```

---

## ▶️ Cómo ejecutar el script

### Opción A — Desde la terminal MySQL

```bash
mysql -u root -p < encuestas_anonimas.sql
```

### Opción B — Desde phpMyAdmin

1. Abrir phpMyAdmin
2. Ir a la pestaña **SQL**
3. Pegar el contenido del script
4. Clic en **Ejecutar**

### Opción C — Desde TablePlus / DBeaver

1. Abrir una conexión a tu servidor MySQL
2. Crear una nueva consulta
3. Pegar y ejecutar el script completo

> El script crea automáticamente la base de datos `encuestas_db` e incluye datos de prueba listos para consultar.

---

*Motor: MySQL 8.0+ · Charset: utf8mb4 · Collation: utf8mb4_unicode_ci*
