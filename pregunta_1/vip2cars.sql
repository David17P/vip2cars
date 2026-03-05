-- ============================================================
--  Sistema de Encuestas Anónimas
--  Motor: MySQL 8.0+
--  Autor: Jorge Munayco Peralta
-- ============================================================

CREATE DATABASE IF NOT EXISTS encuestas_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE encuestas_db;

-- ============================================================
-- 1. Creacion de la tabla USER(Usuarios)
-- ============================================================
CREATE TABLE users (
    id           BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name         VARCHAR(100)  NOT NULL,
    email        VARCHAR(150)  NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role         ENUM('admin', 'editor', 'viewer') NOT NULL DEFAULT 'editor',
    created_at   TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at   TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    UNIQUE KEY uq_users_email (email)
) ENGINE=InnoDB;


-- ============================================================
-- 2. Creacion de la tabla SURVEYS — Encuestas
-- ============================================================
CREATE TABLE surveys (
    id           BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    created_by   BIGINT UNSIGNED NOT NULL,
    title        VARCHAR(200)  NOT NULL,
    description  TEXT,
    status       ENUM('draft', 'active', 'closed') NOT NULL DEFAULT 'draft',
    is_anonymous BOOLEAN       NOT NULL DEFAULT TRUE,
    starts_at    DATETIME,
    ends_at      DATETIME,
    created_at   TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at   TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_surveys_user
        FOREIGN KEY (created_by) REFERENCES users(id)
        ON DELETE RESTRICT ON UPDATE CASCADE,

    INDEX idx_surveys_status (status),
    INDEX idx_surveys_created_by (created_by)
) ENGINE=InnoDB;


-- ============================================================
-- 3. Creacion de la tabla QUESTIONS- Esta tabla me sirve para las preguntas de la encuesta
-- ============================================================
CREATE TABLE questions (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    survey_id   BIGINT UNSIGNED NOT NULL,
    text        TEXT          NOT NULL,
    type        ENUM('single', 'multiple', 'text', 'scale', 'boolean') NOT NULL,
    is_required BOOLEAN       NOT NULL DEFAULT FALSE,
    `order`     SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    created_at  TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_questions_survey
        FOREIGN KEY (survey_id) REFERENCES surveys(id)
        ON DELETE CASCADE ON UPDATE CASCADE,

    INDEX idx_questions_survey (survey_id),
    INDEX idx_questions_order  (survey_id, `order`)
) ENGINE=InnoDB;


-- ============================================================
-- 4. Creacion de la tabla OPTIONS — Esto es para las opciones de las pregunatas
-- ============================================================
CREATE TABLE options (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    question_id BIGINT UNSIGNED NOT NULL,
    text        VARCHAR(300)  NOT NULL,
    `order`     SMALLINT UNSIGNED NOT NULL DEFAULT 0,

    CONSTRAINT fk_options_question
        FOREIGN KEY (question_id) REFERENCES questions(id)
        ON DELETE CASCADE ON UPDATE CASCADE,

    INDEX idx_options_question (question_id)
) ENGINE=InnoDB;


-- ============================================================
-- 5. Creacion de la tabla RESPONSES — Sesión de respuesta anónima
--        MENSAJEEEEEEEEEEEEE:
--        No Guardo el user_id. Aca garantizo el anonimato
--        mediante un UUID generado aleatoriamente.
-- ============================================================
CREATE TABLE responses (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    survey_id       BIGINT UNSIGNED NOT NULL,
    anonymous_token CHAR(36)      NOT NULL COMMENT 'UUID v4 generado en el momento de responder',
    ip_hash         VARCHAR(64)   NULL     COMMENT 'SHA-256 de la IP, sólo para control de duplicados',
    submitted_at    TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_responses_survey
        FOREIGN KEY (survey_id) REFERENCES surveys(id)
        ON DELETE CASCADE ON UPDATE CASCADE,

    UNIQUE KEY uq_responses_token (anonymous_token),
    INDEX idx_responses_survey    (survey_id),
    -- Índice para detección de duplicados por IP (opcional)
    INDEX idx_responses_ip_hash   (survey_id, ip_hash)
) ENGINE=InnoDB;


-- ============================================================
-- 6. Creacion de la tabla ANSWERS — Respuestas individuales por pregunta
-- ============================================================
CREATE TABLE answers (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    response_id BIGINT UNSIGNED NOT NULL,
    question_id BIGINT UNSIGNED NOT NULL,
    option_id   BIGINT UNSIGNED NULL COMMENT 'Para tipo single/multiple',
    text_value  TEXT            NULL COMMENT 'Para tipo text',
    scale_value TINYINT         NULL COMMENT 'Para tipo scale (ej. 1-10)',

    CONSTRAINT fk_answers_response
        FOREIGN KEY (response_id) REFERENCES responses(id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_answers_question
        FOREIGN KEY (question_id) REFERENCES questions(id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_answers_option
        FOREIGN KEY (option_id) REFERENCES options(id)
        ON DELETE SET NULL ON UPDATE CASCADE,

    INDEX idx_answers_response (response_id),
    INDEX idx_answers_question (question_id)
) ENGINE=InnoDB;


-- ============================================================
-- DATOS DE PRUEBA
-- ============================================================

-- Usuario administrador
INSERT INTO users (name, email, password_hash, role) VALUES
('Admin Sistema', 'admin@encuestas.com', SHA2('password123', 256), 'admin');

-- Encuesta de ejemplo
INSERT INTO surveys (created_by, title, description, status, is_anonymous, starts_at, ends_at)
VALUES (1, 'Satisfacción Laboral Q1 2026', 'Encuesta trimestral de clima laboral', 'active', TRUE,
        '2026-01-01 00:00:00', '2026-03-31 23:59:59');

-- Preguntas
INSERT INTO questions (survey_id, text, type, is_required, `order`) VALUES
(1, '¿Cómo calificarías tu satisfacción general en el trabajo?', 'scale',    TRUE,  1),
(1, '¿Qué aspectos valoras más de tu trabajo?',                  'multiple', FALSE, 2),
(1, '¿Tienes algún comentario adicional?',                        'text',     FALSE, 3);

-- Opciones para la pregunta 2
INSERT INTO options (question_id, text, `order`) VALUES
(2, 'Ambiente de trabajo',    1),
(2, 'Salario y beneficios',   2),
(2, 'Oportunidades de crecimiento', 3),
(2, 'Flexibilidad horaria',   4),
(2, 'Equipo de trabajo',      5);

-- Respuesta anónima de ejemplo
INSERT INTO responses (survey_id, anonymous_token, ip_hash)
VALUES (1, UUID(), SHA2('192.168.1.100', 256));

-- Respuestas de ejemplo
INSERT INTO answers (response_id, question_id, scale_value) VALUES (1, 1, 8);
INSERT INTO answers (response_id, question_id, option_id)   VALUES (1, 2, 1);
INSERT INTO answers (response_id, question_id, option_id)   VALUES (1, 2, 3);
INSERT INTO answers (response_id, question_id, text_value)  VALUES (1, 3, 'Muy buena encuesta, sigan así.');


-- ============================================================
-- VISTAS PARA VER LA DATA
-- ============================================================
-- vista: Resumen de respuestas por encuesta
CREATE OR REPLACE VIEW v_survey_summary AS
SELECT
    s.id          AS survey_id,
    s.title,
    s.status,
    COUNT(r.id)   AS total_responses,
    MIN(r.submitted_at) AS first_response,
    MAX(r.submitted_at) AS last_response
FROM surveys s
LEFT JOIN responses r ON r.survey_id = s.id
GROUP BY s.id, s.title, s.status;

-- Vista: Conteo de respuestas por opción
CREATE OR REPLACE VIEW v_option_counts AS
SELECT
    q.survey_id,
    q.id         AS question_id,
    q.text       AS question_text,
    o.id         AS option_id,
    o.text       AS option_text,
    COUNT(a.id)  AS count
FROM questions q
JOIN options   o ON o.question_id = q.id
LEFT JOIN answers a ON a.option_id = o.id
GROUP BY q.survey_id, q.id, q.text, o.id, o.text;