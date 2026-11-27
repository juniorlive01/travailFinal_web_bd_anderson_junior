-- =====================================================================
-- Travail pratique A26 - Gestionnaire de tickets de support
-- Données initiales et de tests (exécuter APRÈS bd.sql)
-- L'ordre des insertions respecte les clés étrangères ET les triggers.
-- =====================================================================

USE ticket_manager;
SET NAMES utf8mb4;
SELECT * FROM role;

-- Mot de passe de TOUS les comptes de test : Support#2026 (hash bcrypt valide, compatible password_verify)
SET @pwd := '$2y$10$ZJuh7E2L.YwOYvS5iH/KK.4NlOrB4hAP/TgwlUzIsLHmP2CqI3thC';

-- ---------------------------------------------------------------------
-- Tables de référence
-- ---------------------------------------------------------------------
INSERT INTO role (id_role, role_name, description) VALUES
(1, 'Utilisateur',    'Crée des tickets et consulte les siens'),
(2, 'Technicien',     'Prend en charge et résout les tickets'),
(3, 'Gestionnaire',   'Consulte les statistiques de performance'),
(4, 'Administrateur', 'Gère les comptes et la configuration');

INSERT INTO ticket_status (id_ticket_status, status_name, is_done) VALUES
(1, 'Nouveau',    0),
(2, 'Assigné',    0),
(3, 'En cours',   0),
(4, 'En attente', 0),
(5, 'Résolu',     1),
(6, 'Annulé',     1);

INSERT INTO priority (id_priority, level_name) VALUES
(1, 'Urgente'),
(2, 'Élevée'),
(3, 'Normale'),
(4, 'Faible');

INSERT INTO category (id_category, category_name) VALUES
(1, 'Matériel'),
(2, 'Logiciel'),
(3, 'Réseau'),
(4, 'Compte utilisateur'),
(5, 'Impression'),
(6, 'Autre');

INSERT INTO problem_type (id_problem_type, problem_name, id_category) VALUES
(1,  'Écran défectueux',                1),
(2,  'Clavier ou souris défectueux',    1),
(3,  'Ordinateur qui ne démarre pas',   1),
(4,  'Installation de logiciel',        2),
(5,  'Application qui plante',          2),
(6,  'Panne Wi-Fi',                     3),
(7,  'Connexion VPN impossible',        3),
(8,  'Mot de passe oublié',             4),
(9,  'Demande d''accès',                4),
(10, 'Panne ou bourrage d''imprimante', 5),
(11, 'Téléphone IP sans tonalité',      3),
(12, 'Autre problème',                  6),
-- Un type "générique" par catégorie : le formulaire web ne demande que la catégorie,
-- le PHP rattache alors le ticket au type 'Autre problème' de la catégorie choisie.
(13, 'Autre problème',                  1),
(14, 'Autre problème',                  2),
(15, 'Autre problème',                  3),
(16, 'Autre problème',                  4),
(17, 'Autre problème',                  5);

INSERT INTO mime_type (id_mime_type, type_name) VALUES
(1, 'image/jpeg'),
(2, 'image/png'),
(3, 'application/pdf'),
(4, 'text/plain'),
(5, 'application/zip'),
(6, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');

INSERT INTO brand (id_brand, brand_name) VALUES
(1, 'Dell'),
(2, 'HP'),
(3, 'Lenovo'),
(4, 'Brother'),
(5, 'Ubiquiti'),
(6, 'Cisco');

INSERT INTO device_type (id_device_type, name, description) VALUES
(1, 'Ordinateur portable', 'Poste informatique mobile'),
(2, 'Ordinateur de bureau', 'Poste informatique fixe'),
(3, 'Imprimante', 'Imprimante laser ou multifonction'),
(4, 'Téléphone IP', 'Téléphone de bureau sur réseau'),
(5, 'Écran', 'Moniteur externe'),
(6, 'Borne Wi-Fi', 'Point d''accès sans fil');

INSERT INTO device_model (id_device_model, model_name, description, id_brand, id_device_type) VALUES
(1, 'Latitude 5440',    'Portable professionnel 14 po',   1, 1),
(2, 'EliteDesk 800 G9', 'Poste de bureau compact',        2, 2),
(3, 'HL-L6200DW',       'Imprimante laser monochrome',    4, 3),
(4, 'ThinkPad T14',     'Portable professionnel 14 po',   3, 1),
(5, 'P2422H',           'Écran 24 po Full HD',            1, 5),
(6, 'U6-Pro',           'Borne Wi-Fi 6',                  5, 6),
(7, '8845',             'Téléphone IP vidéo',             6, 4),
(8, 'ProBook 450 G10',  'Portable 15 po',                 2, 1),
(9, 'OptiPlex 7010',    'Poste de bureau',                1, 2);

-- ---------------------------------------------------------------------
-- Géographie et lieux
-- ---------------------------------------------------------------------
INSERT INTO country (id_country, name) VALUES
(1, 'Canada'),
(2, 'États-Unis'),
(3, 'France'),
(4, 'Mexique'),
(5, 'Belgique');

INSERT INTO province (id_province, name, id_country) VALUES
(1, 'Québec',               1),
(2, 'Ontario',              1),
(3, 'Nouveau-Brunswick',    1),
(4, 'Colombie-Britannique', 1),
(5, 'Nouvelle-Écosse',      1);

INSERT INTO city (id_city, name, id_province) VALUES
(1, 'Saint-Georges', 1),
(2, 'Québec',        1),
(3, 'Lévis',         1),
(4, 'Montréal',      1),
(5, 'Ottawa',        2);

INSERT INTO address (id_address, street_name, street_number, id_city) VALUES
(1, 'rue de l''Université',  '100', 1),
(2, 'boulevard des Sciences','250', 1),
(3, 'avenue Centrale',       '75',  3),
(4, 'rue du Savoir',         '12',  2),
(5, 'rue de la Formation',   '480', 4);

INSERT INTO site (id_site, name, description, id_address) VALUES
(1, 'Campus principal',      'Bâtiments d''enseignement',    1),
(2, 'Pavillon des sciences', 'Laboratoires',                 2),
(3, 'Centre administratif',  'Direction et administration',  3),
(4, 'Bibliothèque centrale', 'Salles de lecture',            4),
(5, 'Centre de formation',   'Ateliers de formation continue', 5);

INSERT INTO room (id_room, room_number, floor_level, id_site) VALUES
(1, 'A-101', '1', 1),
(2, 'A-204', '2', 1),
(3, 'B-110', '1', 2),
(4, 'B-215', '2', 2),
(5, 'C-001', 'RDC', 3),
(6, 'C-310', '3', 3),
(7, 'D-020', 'SS', 4),
(8, 'E-105', '1', 5);

INSERT INTO device (id_device, serial_number, id_room, id_device_model) VALUES
(1, 'SN-DL5440-0001', 1,    1),
(2, 'SN-HP800-0002',  3,    2),
(3, 'SN-BR6200-0003', 5,    3),
(4, 'SN-LT14-0004',   6,    4),
(5, 'SN-DP2422-0005', 3,    5),
(6, 'SN-UB6P-0006',   4,    6),
(7, 'SN-CS8845-0007', 6,    7),
(8, 'SN-HP450-0008',  NULL, 8),
(9, 'SN-DO7010-0009', 8,    9);

-- ---------------------------------------------------------------------
-- Utilisateurs (1-6 usagers, 7-11 techniciens, 12-13 gestionnaires, 14 admin)
-- ---------------------------------------------------------------------
INSERT INTO app_user (id_user, last_name, first_name, phone, email, created_at, password_hash, is_active, id_site) VALUES
(1,  'Tremblay',  'Marie',     '418-555-0101', 'marie.tremblay@exemple.ca',    '2026-01-10 09:00:00', @pwd, 1, 1),
(2,  'Gagnon',    'Jean',      '418-555-0102', 'jean.gagnon@exemple.ca',       '2026-01-10 09:05:00', @pwd, 1, 2),
(3,  'Roy',       'Sophie',    '418-555-0103', 'sophie.roy@exemple.ca',        '2026-01-10 09:10:00', @pwd, 1, 3),
(4,  'Bouchard',  'Luc',       '418-555-0104', 'luc.bouchard@exemple.ca',      '2026-01-10 09:15:00', @pwd, 1, 4),
(5,  'Côté',      'Émilie',    '418-555-0105', 'emilie.cote@exemple.ca',       '2026-01-10 09:20:00', @pwd, 1, 1),
(6,  'Benali',    'Karim',     '418-555-0106', 'karim.benali@exemple.ca',      '2026-01-10 09:25:00', @pwd, 1, 5),
(7,  'Lavoie',    'Alexandre', '418-555-0201', 'alexandre.lavoie@exemple.ca',  '2022-08-15 08:00:00', @pwd, 1, 1),
(8,  'Fortin',    'Isabelle',  '418-555-0202', 'isabelle.fortin@exemple.ca',   '2020-01-20 08:00:00', @pwd, 1, 1),
(9,  'Pelletier', 'Mathieu',   '418-555-0203', 'mathieu.pelletier@exemple.ca', '2023-05-02 08:00:00', @pwd, 1, 1),
(10, 'Gauthier',  'Nadia',     '418-555-0204', 'nadia.gauthier@exemple.ca',    '2019-09-09 08:00:00', @pwd, 1, 3),
(11, 'Morin',     'Samuel',    '418-555-0205', 'samuel.morin@exemple.ca',      '2024-03-18 08:00:00', @pwd, 1, 3),
(12, 'Lefebvre',  'Julie',     '418-555-0301', 'julie.lefebvre@exemple.ca',    '2021-06-01 08:00:00', @pwd, 1, 3),
(13, 'Gagné',     'Pierre',    '418-555-0302', 'pierre.gagne@exemple.ca',      '2021-06-01 08:05:00', @pwd, 1, 3),
(14, 'Système',   'Admin',     '418-555-0001', 'admin@exemple.ca',             '2019-01-01 08:00:00', @pwd, 1, 3);

INSERT INTO app_user_role (id_user, id_role, attribution_date) VALUES
(1, 1, '2026-01-10'), (2, 1, '2026-01-10'), (3, 1, '2026-01-10'),
(4, 1, '2026-01-10'), (5, 1, '2026-01-10'), (6, 1, '2026-01-10'),
(7, 2, '2022-08-15'), (8, 2, '2020-01-20'), (9, 2, '2023-05-02'),
(10, 2, '2019-09-09'), (11, 2, '2024-03-18'),
(12, 3, '2021-06-01'), (13, 3, '2021-06-01'),
(14, 4, '2019-01-01');

INSERT INTO end_user (id_user) VALUES (1), (2), (3), (4), (5), (6);

INSERT INTO technician (id_user, hire_date) VALUES
(7,  '2022-08-15'),
(8,  '2020-01-20'),
(9,  '2023-05-02'),
(10, '2019-09-09'),
(11, '2024-03-18');

INSERT INTO technician_rate (id_technician_rate, hourly_amount, start_date, end_date, id_user) VALUES
(1, 36.00, '2022-08-15', '2025-12-31', 7),
(2, 38.50, '2026-01-01', NULL,         7),
(3, 42.00, '2020-01-20', NULL,         8),
(4, 35.75, '2023-05-02', NULL,         9),
(5, 45.00, '2019-09-09', NULL,         10),
(6, 33.00, '2024-03-18', NULL,         11);

-- ---------------------------------------------------------------------
-- Problèmes et tickets (le statut est mis à jour par trigger via l'historique)
-- ---------------------------------------------------------------------
INSERT INTO problem (id_problem, description, id_room, id_problem_type) VALUES
(1,  'Mon poste s''allume mais l''écran reste noir.',                       3,    1),
(2,  'La connexion Wi-Fi tombe plusieurs fois par heure.',                  4,    6),
(3,  'Les pages sortent froissées puis l''imprimante affiche une erreur.',  5,    10),
(4,  'J''ai besoin d''Acrobat Pro sur mon portable.',                       7,    4),
(5,  'Je n''arrive plus à me connecter à ma session.',                      2,    8),
(6,  'Plusieurs touches du clavier ne fonctionnent plus.',                  8,    2),
(7,  'Le client VPN affiche une erreur de connexion en télétravail.',       NULL, 7),
(8,  'Je dois consulter le dossier partagé du département des finances.',   NULL, 9),
(9,  'Écran noir complet, aucune réaction au bouton d''alimentation.',      6,    3),
(10, 'L''application de paie se ferme à l''ouverture du module des heures.',7,    5),
(11, 'Mon téléphone de bureau n''a plus de tonalité.',                      6,    11);

INSERT INTO ticket (id_ticket, title, creation_date, id_user, id_ticket_status, id_problem, id_priority) VALUES
(1,  'Écran noir au démarrage',               '2026-10-05 08:30:00', 1, 1, 1,  2),
(2,  'Wi-Fi instable au laboratoire',         '2026-11-10 09:00:00', 2, 1, 2,  2),
(3,  'Imprimante de la réception hors service','2026-11-12 10:20:00', 3, 1, 3,  3),
(4,  'Installer Adobe Acrobat',               '2026-10-20 14:00:00', 4, 1, 4,  4),
(5,  'Mot de passe oublié',                   '2026-11-02 09:45:00', 5, 1, 5,  3),
(6,  'Clavier qui ne répond plus',            '2026-10-28 13:00:00', 6, 1, 6,  3),
(7,  'VPN impossible à connecter',            '2026-11-17 16:20:00', 1, 1, 7,  2),
(8,  'Accès au dossier partagé Finances',     '2026-11-18 14:05:00', 2, 1, 8,  4),
(9,  'Portable qui ne démarre plus',          '2026-11-19 07:50:00', 3, 1, 9,  1),
(10, 'Application de paie qui plante',        '2026-09-30 10:00:00', 4, 1, 10, 2),
(11, 'Téléphone IP sans tonalité',            '2026-11-05 10:00:00', 2, 1, 11, 3),
-- Deuxième ticket pour le MÊME problème (signalement en double du Wi-Fi)
(12, 'Wi-Fi aussi coupé de notre côté',       '2026-11-11 14:00:00', 4, 1, 2,  3);

INSERT INTO device_ticket (id_device, id_ticket) VALUES
(2, 1), (5, 1), (6, 2), (3, 3), (8, 4), (9, 6),
(1, 7), (4, 9), (8, 10), (7, 11), (6, 12);

-- ---------------------------------------------------------------------
-- Assignations (le ticket 2 a été réassigné de Nadia à Isabelle)
-- ---------------------------------------------------------------------
INSERT INTO assignment (id_assignment, start_date, end_date, id_ticket, id_user) VALUES
(1,  '2026-10-05 09:15:00', '2026-10-05 11:30:00', 1,  7),
(2,  '2026-11-10 13:00:00', '2026-11-10 16:00:00', 2,  10),
(3,  '2026-11-10 16:00:00', NULL,                  2,  8),
(4,  '2026-11-12 11:00:00', NULL,                  3,  9),
(5,  '2026-10-21 08:00:00', '2026-10-21 09:10:00', 4,  10),
(6,  '2026-11-02 09:50:00', '2026-11-02 10:10:00', 5,  11),
(7,  '2026-10-29 08:00:00', '2026-10-29 09:00:00', 6,  7),
(8,  '2026-11-18 08:45:00', NULL,                  7,  8),
(9,  '2026-09-30 11:00:00', '2026-10-01 09:00:00', 10, 9),
(10, '2026-11-05 10:30:00', '2026-11-05 13:00:00', 11, 11);

-- ---------------------------------------------------------------------
-- Historique des statuts (insérer dans l'ordre chronologique)
-- ---------------------------------------------------------------------
INSERT INTO history_ticket_status (change_date, id_user, id_ticket_status, id_ticket) VALUES
('2026-10-05 08:30:00', 1,  1, 1),
('2026-10-05 09:15:00', 7,  2, 1),
('2026-10-05 10:00:00', 7,  3, 1),
('2026-10-05 11:30:00', 7,  5, 1),
('2026-11-10 09:00:00', 2,  1, 2),
('2026-11-10 13:00:00', 10, 2, 2),
('2026-11-11 08:30:00', 8,  3, 2),
('2026-11-12 10:20:00', 3,  1, 3),
('2026-11-12 11:00:00', 9,  2, 3),
('2026-11-12 13:30:00', 9,  3, 3),
('2026-11-13 09:00:00', 9,  4, 3),
('2026-10-20 14:00:00', 4,  1, 4),
('2026-10-21 08:00:00', 10, 2, 4),
('2026-10-21 08:30:00', 10, 3, 4),
('2026-10-21 09:10:00', 10, 5, 4),
('2026-11-02 09:45:00', 5,  1, 5),
('2026-11-02 09:50:00', 11, 2, 5),
('2026-11-02 09:55:00', 11, 3, 5),
('2026-11-02 10:10:00', 11, 5, 5),
('2026-10-28 13:00:00', 6,  1, 6),
('2026-10-29 08:00:00', 7,  2, 6),
('2026-10-29 08:20:00', 7,  3, 6),
('2026-10-29 09:00:00', 7,  5, 6),
('2026-11-17 16:20:00', 1,  1, 7),
('2026-11-18 08:45:00', 8,  2, 7),
('2026-11-18 14:05:00', 2,  1, 8),
('2026-11-19 07:50:00', 3,  1, 9),
('2026-09-30 10:00:00', 4,  1, 10),
('2026-09-30 11:00:00', 9,  2, 10),
('2026-10-01 09:00:00', 4,  6, 10),
('2026-11-05 10:00:00', 2,  1, 11),
('2026-11-05 10:30:00', 11, 2, 11),
('2026-11-05 11:00:00', 11, 3, 11),
('2026-11-05 13:00:00', 11, 5, 11),
('2026-11-11 14:00:00', 4,  1, 12);

-- ---------------------------------------------------------------------
-- Événements (is_private = 1 : techniciens seulement)
-- ---------------------------------------------------------------------
INSERT INTO event (id_event, date_creation, message, is_private, id_user, id_ticket) VALUES
(1,  '2026-10-05 09:20:00', 'Bonjour Marie, je prends en charge votre demande. Le poste est-il bien branché ?', 0, 7,  1),
(2,  '2026-10-05 09:40:00', 'Oui, tout est branché, l''écran reste noir.',                                    0, 1,  1),
(3,  '2026-10-05 10:15:00', 'Note : câble DisplayPort usé, vérifier le lot de câbles en réserve.',            1, 7,  1),
(4,  '2026-10-05 11:25:00', 'Câble remplacé, l''affichage est revenu. Ticket résolu.',                        0, 7,  1),
(5,  '2026-11-11 08:40:00', 'Je vais vérifier la borne Wi-Fi et la couverture du laboratoire.',               0, 8,  2),
(6,  '2026-11-11 09:10:00', 'Firmware de la borne en retard de deux versions, mise à jour après 17 h.',       1, 8,  2),
(7,  '2026-11-11 10:30:00', 'Le problème survient surtout en début d''après-midi. Voir le plan joint.',       0, 2,  2),
(8,  '2026-11-13 09:05:00', 'Le rouleau de fusion est usé. La pièce est commandée, livraison la semaine prochaine.', 0, 9, 3),
(9,  '2026-11-13 09:45:00', 'Merci, nous utiliserons l''imprimante du 3e étage entre-temps.',                 0, 3,  3),
(10, '2026-10-21 09:05:00', 'Adobe Acrobat Pro est installé et activé sur votre portable.',                  0, 10, 4),
(11, '2026-11-02 10:00:00', 'Identité confirmée par téléphone avant la réinitialisation.',                    1, 11, 5),
(12, '2026-11-02 10:08:00', 'Mot de passe temporaire envoyé par courriel, à changer à la prochaine connexion.', 0, 11, 5),
(13, '2026-10-29 08:50:00', 'Le clavier a été remplacé par un neuf.',                                         0, 7,  6),
(14, '2026-11-18 08:50:00', 'Pouvez-vous préciser le message d''erreur affiché par le client VPN ?',          0, 8,  7),
(15, '2026-10-01 09:00:00', 'Annulation : le problème a disparu après un redémarrage.',                       0, 4,  10),
(16, '2026-11-19 07:55:00', 'Le portable est tombé en panne en pleine réunion, besoin urgent.',               0, 3,  9);

-- ---------------------------------------------------------------------
-- Pièces jointes (l'événement, s'il existe, appartient au même ticket)
-- ---------------------------------------------------------------------
INSERT INTO attachment (id_attachment, file_name, date_added, size_bytes, file_path, id_event, id_ticket, id_user, id_mime_type) VALUES
(1, 'ecran_noir.jpg',          '2026-10-05 08:31:00', 184320, 'uploads/2026/10/a1f3c9_ecran_noir.jpg',        NULL, 1,  1, 1),
(2, 'plan_laboratoire.pdf',    '2026-11-11 10:31:00', 523000, 'uploads/2026/11/b2d4e8_plan_laboratoire.pdf',  7,    2,  2, 3),
(3, 'photo_imprimante.jpg',    '2026-11-12 10:22:00', 245760, 'uploads/2026/11/c3e5f7_photo_imprimante.jpg',  NULL, 3,  3, 1),
(4, 'erreur_vpn.png',          '2026-11-17 16:22:00', 98304,  'uploads/2026/11/d4f6a1_erreur_vpn.png',        NULL, 7,  1, 2),
(5, 'photo_portable.jpg',      '2026-11-19 07:56:00', 301056, 'uploads/2026/11/e5a7b2_photo_portable.jpg',    16,   9,  3, 1),
(6, 'rapport_erreur_paie.txt', '2026-09-30 10:02:00', 4096,   'uploads/2026/09/f6b8c3_rapport_erreur_paie.txt', NULL, 10, 4, 4);

-- ---------------------------------------------------------------------
-- Évaluations (tickets fermés seulement)
-- ---------------------------------------------------------------------
INSERT INTO evaluation (id_evaluation, date_evaluation, score, comment_text, id_ticket) VALUES
(1, '2026-10-05 12:00:00', 5, 'Très rapide, merci !',                   1),
(2, '2026-10-21 10:00:00', 4, 'Bon service.',                           4),
(3, '2026-11-02 10:30:00', 5, 'Efficace et courtois.',                  5),
(4, '2026-10-29 10:00:00', 3, 'Un peu long avant la prise en charge.',  6),
(5, '2026-11-05 14:00:00', 4, NULL,                                     11);

-- ---------------------------------------------------------------------
-- Tâches accomplies (temps passé) et actions (coûts)
-- ---------------------------------------------------------------------
INSERT INTO completed_task (id_completed_task, description, start_datetime, end_datetime, id_technician_rate, id_ticket) VALUES
(1,  'Diagnostic du poste et de l''affichage',          '2026-10-05 10:00:00', '2026-10-05 10:30:00', 2, 1),
(2,  'Remplacement du câble DisplayPort',               '2026-10-05 10:45:00', '2026-10-05 11:30:00', 2, 1),
(3,  'Analyse de la couverture Wi-Fi',                  '2026-11-11 08:30:00', '2026-11-11 10:00:00', 3, 2),
(4,  'Diagnostic de l''imprimante',                     '2026-11-12 13:30:00', '2026-11-12 14:30:00', 4, 3),
(5,  'Commande du rouleau de fusion',                   '2026-11-13 09:00:00', '2026-11-13 09:20:00', 4, 3),
(6,  'Installation d''Adobe Acrobat Pro',               '2026-10-21 08:30:00', '2026-10-21 09:10:00', 5, 4),
(7,  'Réinitialisation du mot de passe',                '2026-11-02 09:55:00', '2026-11-02 10:10:00', 6, 5),
(8,  'Remplacement du clavier',                         '2026-10-29 08:20:00', '2026-10-29 08:45:00', 2, 6),
(9,  'Analyse des journaux du VPN',                     '2026-11-18 09:00:00', '2026-11-18 09:30:00', 3, 7),
(10, 'Vérification du poste, aucun défaut détecté',     '2026-09-30 11:00:00', '2026-09-30 11:30:00', 4, 10),
(11, 'Reconfiguration du téléphone IP',                 '2026-11-05 11:00:00', '2026-11-05 12:00:00', 6, 11);

INSERT INTO action (id_action, description, quantity, unit_cost, execution_date, id_ticket, id_user) VALUES
(1, 'Câble DisplayPort de remplacement',            1, 18.50, '2026-10-05 10:50:00', 1,  7),
(2, 'Rouleau de fusion Brother',                    1, 89.99, '2026-11-13 09:10:00', 3,  9),
(3, 'Clavier USB de remplacement',                  1, 20.00, '2026-10-29 08:30:00', 6,  7),
(4, 'Licence Adobe Acrobat Pro (mensuelle)',        1, 19.99, '2026-10-21 08:45:00', 4,  10),
(5, 'Câble réseau Cat6 de 2 m',                     2, 4.50,  '2026-11-05 11:30:00', 11, 11);
