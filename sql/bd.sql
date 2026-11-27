DROP DATABASE IF EXISTS ticket_manager;
CREATE DATABASE ticket_manager
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;
USE ticket_manager;

SET NAMES utf8mb4;

CREATE TABLE role (
    id_role      INT UNSIGNED NOT NULL AUTO_INCREMENT,
    role_name    VARCHAR(50)  NOT NULL,
    description  VARCHAR(255) NULL,
    CONSTRAINT pk_role PRIMARY KEY (id_role),
    CONSTRAINT uq_role_name UNIQUE (role_name)
) ENGINE=InnoDB;

CREATE TABLE country (
    id_country  INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name        VARCHAR(100) NOT NULL,
    CONSTRAINT pk_country PRIMARY KEY (id_country),
    CONSTRAINT uq_country_name UNIQUE (name)
) ENGINE=InnoDB;

CREATE TABLE device_type (
    id_device_type  INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name            VARCHAR(50)  NOT NULL,
    description     VARCHAR(255) NULL,
    CONSTRAINT pk_device_type PRIMARY KEY (id_device_type),
    CONSTRAINT uq_device_type_name UNIQUE (name)
) ENGINE=InnoDB;

CREATE TABLE category (
    id_category    INT UNSIGNED NOT NULL AUTO_INCREMENT,
    category_name  VARCHAR(50)  NOT NULL,
    CONSTRAINT pk_category PRIMARY KEY (id_category),
    CONSTRAINT uq_category_name UNIQUE (category_name)
) ENGINE=InnoDB;

CREATE TABLE problem_type (
    id_problem_type  INT UNSIGNED NOT NULL AUTO_INCREMENT,
    problem_name     VARCHAR(100) NOT NULL,
    id_category      INT UNSIGNED NOT NULL,
    CONSTRAINT pk_problem_type PRIMARY KEY (id_problem_type),
    CONSTRAINT uq_problem_type UNIQUE (id_category, problem_name),
    CONSTRAINT fk_problem_type_category FOREIGN KEY (id_category)
        REFERENCES category (id_category)
) ENGINE=InnoDB;

CREATE TABLE priority (
    id_priority  INT UNSIGNED NOT NULL AUTO_INCREMENT,
    level_name   VARCHAR(30)  NOT NULL,
    CONSTRAINT pk_priority PRIMARY KEY (id_priority),
    CONSTRAINT uq_priority_level UNIQUE (level_name)
) ENGINE=InnoDB;

CREATE TABLE ticket_status (
    id_ticket_status  INT UNSIGNED NOT NULL AUTO_INCREMENT,
    status_name       VARCHAR(30)  NOT NULL,
    is_done           BOOLEAN      NOT NULL DEFAULT 0,
    CONSTRAINT pk_ticket_status PRIMARY KEY (id_ticket_status),
    CONSTRAINT uq_ticket_status_name UNIQUE (status_name)
) ENGINE=InnoDB;

CREATE TABLE mime_type (
    id_mime_type  INT UNSIGNED NOT NULL AUTO_INCREMENT,
    type_name     VARCHAR(100) NOT NULL,
    CONSTRAINT pk_mime_type PRIMARY KEY (id_mime_type),
    CONSTRAINT uq_mime_type_name UNIQUE (type_name)
) ENGINE=InnoDB;

CREATE TABLE brand (
    id_brand    INT UNSIGNED NOT NULL AUTO_INCREMENT,
    brand_name  VARCHAR(50)  NOT NULL,
    CONSTRAINT pk_brand PRIMARY KEY (id_brand),
    CONSTRAINT uq_brand_name UNIQUE (brand_name)
) ENGINE=InnoDB;

CREATE TABLE device_model (
    id_device_model  INT UNSIGNED NOT NULL AUTO_INCREMENT,
    model_name       VARCHAR(80)  NOT NULL,
    description      VARCHAR(255) NULL,
    id_brand         INT UNSIGNED NOT NULL,
    id_device_type   INT UNSIGNED NOT NULL,
    CONSTRAINT pk_device_model PRIMARY KEY (id_device_model),
    CONSTRAINT uq_device_model UNIQUE (id_brand, model_name),
    CONSTRAINT fk_device_model_brand FOREIGN KEY (id_brand)
        REFERENCES brand (id_brand),
    CONSTRAINT fk_device_model_type FOREIGN KEY (id_device_type)
        REFERENCES device_type (id_device_type)
) ENGINE=InnoDB;

CREATE TABLE province (
    id_province  INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name         VARCHAR(100) NOT NULL,
    id_country   INT UNSIGNED NOT NULL,
    CONSTRAINT pk_province PRIMARY KEY (id_province),
    CONSTRAINT uq_province UNIQUE (id_country, name),
    CONSTRAINT fk_province_country FOREIGN KEY (id_country)
        REFERENCES country (id_country)
) ENGINE=InnoDB;

CREATE TABLE city (
    id_city      INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name         VARCHAR(100) NOT NULL,
    id_province  INT UNSIGNED NOT NULL,
    CONSTRAINT pk_city PRIMARY KEY (id_city),
    CONSTRAINT uq_city UNIQUE (id_province, name),
    CONSTRAINT fk_city_province FOREIGN KEY (id_province)
        REFERENCES province (id_province)
) ENGINE=InnoDB;

CREATE TABLE address (
    id_address     INT UNSIGNED NOT NULL AUTO_INCREMENT,
    street_name    VARCHAR(100) NOT NULL,
    street_number  VARCHAR(10)  NOT NULL,
    id_city        INT UNSIGNED NOT NULL,
    CONSTRAINT pk_address PRIMARY KEY (id_address),
    CONSTRAINT uq_address UNIQUE (id_city, street_name, street_number),
    CONSTRAINT fk_address_city FOREIGN KEY (id_city)
        REFERENCES city (id_city)
) ENGINE=InnoDB;

CREATE TABLE site (
    id_site      INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name         VARCHAR(100) NOT NULL,
    description  VARCHAR(255) NULL,
    id_address   INT UNSIGNED NOT NULL,
    CONSTRAINT pk_site PRIMARY KEY (id_site),
    CONSTRAINT uq_site_name UNIQUE (name),
    CONSTRAINT fk_site_address FOREIGN KEY (id_address)
        REFERENCES address (id_address)
) ENGINE=InnoDB;

CREATE TABLE room (
    id_room       INT UNSIGNED NOT NULL AUTO_INCREMENT,
    room_number   VARCHAR(20)  NOT NULL,
    floor_level   VARCHAR(10)  NULL,
    id_site       INT UNSIGNED NOT NULL,
    CONSTRAINT pk_room PRIMARY KEY (id_room),
    CONSTRAINT uq_room UNIQUE (id_site, room_number),
    CONSTRAINT fk_room_site FOREIGN KEY (id_site)
        REFERENCES site (id_site)
) ENGINE=InnoDB;

CREATE TABLE device (
    id_device        INT UNSIGNED NOT NULL AUTO_INCREMENT,
    serial_number    VARCHAR(60)  NOT NULL,
    id_room          INT UNSIGNED NULL,
    id_device_model  INT UNSIGNED NOT NULL,
    CONSTRAINT pk_device PRIMARY KEY (id_device),
    CONSTRAINT uq_device_serial UNIQUE (serial_number),
    CONSTRAINT fk_device_room FOREIGN KEY (id_room)
        REFERENCES room (id_room) ON DELETE SET NULL,
    CONSTRAINT fk_device_model FOREIGN KEY (id_device_model)
        REFERENCES device_model (id_device_model)
) ENGINE=InnoDB;

CREATE TABLE app_user (
    id_user        INT UNSIGNED NOT NULL AUTO_INCREMENT,
    last_name      VARCHAR(50)  NOT NULL,
    first_name     VARCHAR(50)  NOT NULL,
    phone          VARCHAR(20)  NOT NULL,
    email          VARCHAR(255) NOT NULL,
    created_at     DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    password_hash  VARCHAR(255) NOT NULL,
    is_active      BOOLEAN      NOT NULL DEFAULT 1,
    id_site        INT UNSIGNED NOT NULL,
    CONSTRAINT pk_app_user PRIMARY KEY (id_user),
    CONSTRAINT uq_app_user_email UNIQUE (email),
    CONSTRAINT fk_app_user_site FOREIGN KEY (id_site)
        REFERENCES site (id_site)
) ENGINE=InnoDB;

CREATE TABLE end_user (
    id_user  INT UNSIGNED NOT NULL,
    CONSTRAINT pk_end_user PRIMARY KEY (id_user),
    CONSTRAINT fk_end_user_user FOREIGN KEY (id_user)
        REFERENCES app_user (id_user)
) ENGINE=InnoDB;

CREATE TABLE technician (
    id_user     INT UNSIGNED NOT NULL,
    hire_date   DATE         NOT NULL,
    CONSTRAINT pk_technician PRIMARY KEY (id_user),
    CONSTRAINT fk_technician_user FOREIGN KEY (id_user)
        REFERENCES app_user (id_user)
) ENGINE=InnoDB;

CREATE TABLE app_user_role (
    id_user           INT UNSIGNED NOT NULL,
    id_role           INT UNSIGNED NOT NULL,
    attribution_date  DATE         NOT NULL,
    CONSTRAINT pk_app_user_role PRIMARY KEY (id_user, id_role),
    CONSTRAINT fk_app_user_role_user FOREIGN KEY (id_user)
        REFERENCES app_user (id_user),
    CONSTRAINT fk_app_user_role_role FOREIGN KEY (id_role)
        REFERENCES role (id_role)
) ENGINE=InnoDB;

CREATE TABLE technician_rate (
    id_technician_rate  INT UNSIGNED  NOT NULL AUTO_INCREMENT,
    hourly_amount       DECIMAL(8,2)  NOT NULL,
    start_date          DATE          NOT NULL,
    end_date            DATE          NULL,
    id_user             INT UNSIGNED  NOT NULL,
    CONSTRAINT pk_technician_rate PRIMARY KEY (id_technician_rate),
    CONSTRAINT uq_technician_rate UNIQUE (id_user, start_date),
    CONSTRAINT ck_technician_rate_amount CHECK (hourly_amount > 0),
    CONSTRAINT ck_technician_rate_dates CHECK (end_date IS NULL OR end_date >= start_date),
    CONSTRAINT fk_technician_rate_tech FOREIGN KEY (id_user)
        REFERENCES technician (id_user)
) ENGINE=InnoDB;

CREATE TABLE problem (
    id_problem       INT UNSIGNED NOT NULL AUTO_INCREMENT,
    description      TEXT         NOT NULL,
    id_room          INT UNSIGNED NULL,
    id_problem_type  INT UNSIGNED NOT NULL,
    CONSTRAINT pk_problem PRIMARY KEY (id_problem),
    CONSTRAINT fk_problem_room FOREIGN KEY (id_room)
        REFERENCES room (id_room) ON DELETE SET NULL,
    CONSTRAINT fk_problem_type FOREIGN KEY (id_problem_type)
        REFERENCES problem_type (id_problem_type)
) ENGINE=InnoDB;

CREATE TABLE ticket (
    id_ticket         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    title             VARCHAR(150) NOT NULL,
    creation_date     DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    id_user           INT UNSIGNED NOT NULL,
    id_ticket_status  INT UNSIGNED NOT NULL,
    id_problem        INT UNSIGNED NOT NULL,
    id_priority       INT UNSIGNED NOT NULL,
    CONSTRAINT pk_ticket PRIMARY KEY (id_ticket),
    CONSTRAINT fk_ticket_user FOREIGN KEY (id_user)
        REFERENCES end_user (id_user),
    CONSTRAINT fk_ticket_status FOREIGN KEY (id_ticket_status)
        REFERENCES ticket_status (id_ticket_status),
    CONSTRAINT fk_ticket_problem FOREIGN KEY (id_problem)
        REFERENCES problem (id_problem),
    CONSTRAINT fk_ticket_priority FOREIGN KEY (id_priority)
        REFERENCES priority (id_priority)
) ENGINE=InnoDB;

CREATE TABLE device_ticket (
    id_device  INT UNSIGNED NOT NULL,
    id_ticket  INT UNSIGNED NOT NULL,
    CONSTRAINT pk_device_ticket PRIMARY KEY (id_device, id_ticket),
    CONSTRAINT fk_device_ticket_device FOREIGN KEY (id_device)
        REFERENCES device (id_device),
    CONSTRAINT fk_device_ticket_ticket FOREIGN KEY (id_ticket)
        REFERENCES ticket (id_ticket) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE history_ticket_status (
    id_history_ticket_status  INT UNSIGNED NOT NULL AUTO_INCREMENT,
    change_date               DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    id_user                   INT UNSIGNED NOT NULL,
    id_ticket_status          INT UNSIGNED NOT NULL,
    id_ticket                 INT UNSIGNED NOT NULL,
    CONSTRAINT pk_history_ticket_status PRIMARY KEY (id_history_ticket_status),
    CONSTRAINT fk_history_user FOREIGN KEY (id_user)
        REFERENCES app_user (id_user),
    CONSTRAINT fk_history_status FOREIGN KEY (id_ticket_status)
        REFERENCES ticket_status (id_ticket_status),
    CONSTRAINT fk_history_ticket FOREIGN KEY (id_ticket)
        REFERENCES ticket (id_ticket)
) ENGINE=InnoDB;

CREATE INDEX idx_history_ticket_date ON history_ticket_status (id_ticket, change_date);

CREATE TABLE assignment (
    id_assignment  INT UNSIGNED NOT NULL AUTO_INCREMENT,
    start_date     DATETIME     NOT NULL,
    end_date       DATETIME     NULL,
    id_ticket      INT UNSIGNED NOT NULL,
    id_user        INT UNSIGNED NOT NULL,
    CONSTRAINT pk_assignment PRIMARY KEY (id_assignment),
    CONSTRAINT ck_assignment_dates CHECK (end_date IS NULL OR end_date >= start_date),
    CONSTRAINT fk_assignment_ticket FOREIGN KEY (id_ticket)
        REFERENCES ticket (id_ticket),
    CONSTRAINT fk_assignment_tech FOREIGN KEY (id_user)
        REFERENCES technician (id_user)
) ENGINE=InnoDB;

CREATE TABLE evaluation (
    id_evaluation    INT UNSIGNED     NOT NULL AUTO_INCREMENT,
    date_evaluation  DATETIME         NOT NULL DEFAULT CURRENT_TIMESTAMP,
    score            TINYINT UNSIGNED NOT NULL,
    comment_text     TEXT             NULL,
    id_ticket        INT UNSIGNED     NOT NULL,
    CONSTRAINT pk_evaluation PRIMARY KEY (id_evaluation),
    CONSTRAINT uq_evaluation_ticket UNIQUE (id_ticket),
    CONSTRAINT ck_evaluation_score CHECK (score BETWEEN 1 AND 5),
    CONSTRAINT fk_evaluation_ticket FOREIGN KEY (id_ticket)
        REFERENCES ticket (id_ticket)
) ENGINE=InnoDB;

CREATE TABLE event (
    id_event       INT UNSIGNED NOT NULL AUTO_INCREMENT,
    date_creation  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    message        TEXT         NOT NULL,
    is_private     BOOLEAN      NOT NULL DEFAULT 0,
    id_user        INT UNSIGNED NOT NULL,
    id_ticket      INT UNSIGNED NOT NULL,
    CONSTRAINT pk_event PRIMARY KEY (id_event),

    CONSTRAINT uq_event_ticket UNIQUE (id_event, id_ticket),
    CONSTRAINT fk_event_user FOREIGN KEY (id_user)
        REFERENCES app_user (id_user),
    CONSTRAINT fk_event_ticket FOREIGN KEY (id_ticket)
        REFERENCES ticket (id_ticket)
) ENGINE=InnoDB;

CREATE INDEX idx_event_ticket_date ON event (id_ticket, date_creation);

CREATE TABLE attachment (
    id_attachment  INT UNSIGNED    NOT NULL AUTO_INCREMENT,
    file_name      VARCHAR(255)    NOT NULL,
    date_added     DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    size_bytes     BIGINT UNSIGNED NOT NULL,
    file_path      VARCHAR(255)    NOT NULL,
    id_event       INT UNSIGNED    NULL,
    id_ticket      INT UNSIGNED    NOT NULL,
    id_user        INT UNSIGNED    NOT NULL,
    id_mime_type   INT UNSIGNED    NOT NULL,
    CONSTRAINT pk_attachment PRIMARY KEY (id_attachment),
    CONSTRAINT uq_attachment_path UNIQUE (file_path),
    CONSTRAINT ck_attachment_size CHECK (size_bytes > 0),
    CONSTRAINT fk_attachment_ticket FOREIGN KEY (id_ticket)
        REFERENCES ticket (id_ticket),
    CONSTRAINT fk_attachment_event FOREIGN KEY (id_event, id_ticket)
        REFERENCES event (id_event, id_ticket),
    CONSTRAINT fk_attachment_user FOREIGN KEY (id_user)
        REFERENCES app_user (id_user),
    CONSTRAINT fk_attachment_mime FOREIGN KEY (id_mime_type)
        REFERENCES mime_type (id_mime_type)
) ENGINE=InnoDB;

CREATE TABLE completed_task (
    id_completed_task   INT UNSIGNED NOT NULL AUTO_INCREMENT,
    description         VARCHAR(255) NOT NULL,
    start_datetime      DATETIME     NOT NULL,
    end_datetime        DATETIME     NOT NULL,
    id_technician_rate  INT UNSIGNED NOT NULL,
    id_ticket           INT UNSIGNED NOT NULL,
    CONSTRAINT pk_completed_task PRIMARY KEY (id_completed_task),
    CONSTRAINT ck_completed_task_dates CHECK (end_datetime > start_datetime),
    CONSTRAINT fk_completed_task_rate FOREIGN KEY (id_technician_rate)
        REFERENCES technician_rate (id_technician_rate),
    CONSTRAINT fk_completed_task_ticket FOREIGN KEY (id_ticket)
        REFERENCES ticket (id_ticket)
) ENGINE=InnoDB;

CREATE TABLE action (
    id_action       INT UNSIGNED  NOT NULL AUTO_INCREMENT,
    description     VARCHAR(500)  NOT NULL,
    quantity        DECIMAL(10,2) NOT NULL DEFAULT 1,
    unit_cost       DECIMAL(10,2) NOT NULL DEFAULT 0,
    execution_date  DATETIME      NOT NULL,
    id_ticket       INT UNSIGNED  NOT NULL,
    id_user         INT UNSIGNED  NOT NULL,
    CONSTRAINT pk_action PRIMARY KEY (id_action),
    CONSTRAINT ck_action_quantity CHECK (quantity > 0),
    CONSTRAINT ck_action_cost CHECK (unit_cost >= 0),
    CONSTRAINT fk_action_ticket FOREIGN KEY (id_ticket)
        REFERENCES ticket (id_ticket),
    CONSTRAINT fk_action_tech FOREIGN KEY (id_user)
        REFERENCES technician (id_user)
) ENGINE=InnoDB;


DELIMITER $$

-- TRIGGER : s'execute AUTOMATIQUEMENT quand une requete modifie la table visee.
-- BEFORE INSERT = juste AVANT l'ajout d'une ligne dans event. SIGNAL = refuse l'operation avec une erreur.
-- Role : seul un technicien peut creer un evenement prive (is_private = 1).
CREATE TRIGGER trg_event_bi BEFORE INSERT ON event
FOR EACH ROW
BEGIN
    IF NEW.is_private = 1
       AND NOT EXISTS (SELECT 1 FROM technician WHERE id_user = NEW.id_user) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Seuls les techniciens peuvent creer un evenement prive.';
    END IF;
END$$

-- Meme regle que trg_event_bi, mais BEFORE UPDATE : empeche de rendre prive,
-- apres coup, un evenement ecrit par un non-technicien.
CREATE TRIGGER trg_event_bu BEFORE UPDATE ON event
FOR EACH ROW
BEGIN
    IF NEW.is_private = 1
       AND NOT EXISTS (SELECT 1 FROM technician WHERE id_user = NEW.id_user) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Seuls les techniciens peuvent creer un evenement prive.';
    END IF;
END$$

-- Role : avant d'ajouter une personne dans end_user (employe), verifie qu'elle possede
-- bien le role 'Utilisateur' dans app_user_role. Sinon : erreur.
CREATE TRIGGER trg_end_user_bi BEFORE INSERT ON end_user
FOR EACH ROW
BEGIN
    IF NOT EXISTS (SELECT 1 FROM app_user_role aur
                   JOIN role r ON r.id_role = aur.id_role
                   WHERE aur.id_user = NEW.id_user AND r.role_name = 'Utilisateur') THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'L''utilisateur doit avoir le role Utilisateur.';
    END IF;
END$$

-- Role : avant d'ajouter une personne dans technician, verifie qu'elle possede
-- bien le role 'Technicien' dans app_user_role. Sinon : erreur.
CREATE TRIGGER trg_technician_bi BEFORE INSERT ON technician
FOR EACH ROW
BEGIN
    IF NOT EXISTS (SELECT 1 FROM app_user_role aur
                   JOIN role r ON r.id_role = aur.id_role
                   WHERE aur.id_user = NEW.id_user AND r.role_name = 'Technicien') THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'L''utilisateur doit avoir le role Technicien.';
    END IF;
END$$

-- Role : un technicien ne peut pas avoir deux taux horaires dont les periodes se chevauchent.
-- Une end_date NULL signifie 'sans fin' (remplacee par 9999-12-31 pour comparer).
-- Deux periodes se chevauchent si chacune commence avant la fin de l'autre.
CREATE TRIGGER trg_technician_rate_bi BEFORE INSERT ON technician_rate
FOR EACH ROW
BEGIN
    IF EXISTS (SELECT 1 FROM technician_rate r
               WHERE r.id_user = NEW.id_user
                 AND r.start_date <= COALESCE(NEW.end_date, '9999-12-31')
                 AND COALESCE(r.end_date, '9999-12-31') >= NEW.start_date) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Les periodes de taux horaire se chevauchent.';
    END IF;
END$$

-- Meme regle que trg_technician_rate_bi, mais a la modification.
-- La ligne modifiee est exclue de la comparaison (id_technician_rate <> NEW...),
-- sinon elle serait en conflit avec elle-meme.
CREATE TRIGGER trg_technician_rate_bu BEFORE UPDATE ON technician_rate
FOR EACH ROW
BEGIN
    IF EXISTS (SELECT 1 FROM technician_rate r
               WHERE r.id_user = NEW.id_user
                 AND r.id_technician_rate <> NEW.id_technician_rate
                 AND r.start_date <= COALESCE(NEW.end_date, '9999-12-31')
                 AND COALESCE(r.end_date, '9999-12-31') >= NEW.start_date) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Les periodes de taux horaire se chevauchent.';
    END IF;
END$$

-- Role : un ticket ne peut avoir qu'UNE assignation en cours a la fois
-- (end_date NULL = assignation encore active). Il faut terminer l'ancienne avant d'en creer une.
CREATE TRIGGER trg_assignment_bi BEFORE INSERT ON assignment
FOR EACH ROW
BEGIN
    IF NEW.end_date IS NULL
       AND EXISTS (SELECT 1 FROM assignment
                   WHERE id_ticket = NEW.id_ticket AND end_date IS NULL) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Ce ticket a deja une assignation en cours.';
    END IF;
END$$

-- Role : controle deux choses avant d'enregistrer une tache accomplie :
-- 1) le taux horaire choisi est valide a la date de debut de la tache ;
-- 2) le technicien proprietaire de ce taux est assigne au ticket.
-- (NEW = la ligne en cours d'insertion ; v_* = variables locales du trigger.)
CREATE TRIGGER trg_completed_task_bi BEFORE INSERT ON completed_task
FOR EACH ROW
BEGIN
    DECLARE v_user  INT UNSIGNED;
    DECLARE v_start DATE;
    DECLARE v_end   DATE;

    SELECT id_user, start_date, end_date INTO v_user, v_start, v_end
    FROM technician_rate WHERE id_technician_rate = NEW.id_technician_rate;

    IF DATE(NEW.start_datetime) < v_start
       OR (v_end IS NOT NULL AND DATE(NEW.start_datetime) > v_end) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Le taux horaire choisi n''est pas valide a la date de la tache.';
    END IF;

    IF NOT EXISTS (SELECT 1 FROM assignment
                   WHERE id_ticket = NEW.id_ticket AND id_user = v_user) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Le technicien n''est pas assigne a ce ticket.';
    END IF;
END$$

-- Role : seul un technicien assigne a un ticket peut y enregistrer une action (materiel, deplacement, etc.).
CREATE TRIGGER trg_action_bi BEFORE INSERT ON action
FOR EACH ROW
BEGIN
    IF NOT EXISTS (SELECT 1 FROM assignment
                   WHERE id_ticket = NEW.id_ticket AND id_user = NEW.id_user) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Le technicien n''est pas assigne a ce ticket.';
    END IF;
END$$

-- Role : un ticket ne peut etre evalue que s'il est termine
-- (statut avec is_done = 1, ex. Resolu ou Annule).
CREATE TRIGGER trg_evaluation_bi BEFORE INSERT ON evaluation
FOR EACH ROW
BEGIN
    IF NOT EXISTS (SELECT 1 FROM ticket t
                   JOIN ticket_status s ON s.id_ticket_status = t.id_ticket_status
                   WHERE t.id_ticket = NEW.id_ticket AND s.is_done = 1) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Seul un ticket ferme peut etre evalue.';
    END IF;
END$$

-- AFTER INSERT = juste APRES l'ajout d'une ligne dans history_ticket_status.
-- Role : garde ticket.id_ticket_status synchronise. Pour changer le statut d'un ticket,
-- il suffit d'inserer une ligne dans l'historique : ce trigger met a jour le ticket,
-- a condition que la ligne soit la plus recente (pas de retour en arriere par erreur).
CREATE TRIGGER trg_history_ai AFTER INSERT ON history_ticket_status
FOR EACH ROW
BEGIN
    IF NEW.change_date >= (SELECT MAX(h.change_date)
                           FROM history_ticket_status h
                           WHERE h.id_ticket = NEW.id_ticket) THEN
        UPDATE ticket
        SET id_ticket_status = NEW.id_ticket_status
        WHERE id_ticket = NEW.id_ticket;
    END IF;
END$$

DELIMITER ;
