-- ==========================================
-- SCRIPT DE BASE DE DONNÉES COMPLET (database.sql)
-- ==========================================
-- Ce script nettoie et recrée toutes les tables nécessaires.
-- Il insère également les données de test (Equipes, Matchs, Admin).
-- ==========================================

-- Sélection de la base
USE football_db;

-- 1. NETTOYAGE (Ordre inverse des contraintes FK)
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS tickets;
DROP TABLE IF EXISTS goals;
DROP TABLE IF EXISTS matches;
DROP TABLE IF EXISTS players;
DROP TABLE IF EXISTS teams;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS = 1;

-- ==========================================
-- 2. CRÉATION DES TABLES
-- ==========================================

-- Table Équipes
CREATE TABLE teams (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    logo_url VARCHAR(255) NOT NULL,
    founded INT,
    stadium VARCHAR(100),
    city VARCHAR(50)
);

-- Table Utilisateurs (avec Rôle)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'user', -- 'admin' ou 'user'
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table Matchs
CREATE TABLE matches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    home_team_id INT NOT NULL,
    away_team_id INT NOT NULL,
    home_score INT DEFAULT 0,
    away_score INT DEFAULT 0,
    match_date DATETIME NOT NULL,
    status ENUM('scheduled', 'played', 'live') DEFAULT 'scheduled',
    FOREIGN KEY (home_team_id) REFERENCES teams(id),
    FOREIGN KEY (away_team_id) REFERENCES teams(id)
);

-- Table Joueurs
CREATE TABLE players (
    id INT AUTO_INCREMENT PRIMARY KEY,
    team_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    position ENUM('GK', 'DEF', 'MIL', 'ATT') NOT NULL,
    number INT,
    FOREIGN KEY (team_id) REFERENCES teams(id)
);

-- Table Buts (Pour les stats)
CREATE TABLE goals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    match_id INT NOT NULL,
    player_id INT NOT NULL,
    minute INT,
    FOREIGN KEY (match_id) REFERENCES matches(id),
    FOREIGN KEY (player_id) REFERENCES players(id)
);

-- Table Billets (Billetterie)
CREATE TABLE tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    match_id INT NOT NULL,
    quantity INT DEFAULT 1,
    zone INT DEFAULT 1, -- 1: Virage, 2: Tribune, 3: Premium, 4: VIP
    ticket_code VARCHAR(20) UNIQUE NOT NULL,
    purchase_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (match_id) REFERENCES matches(id)
);

-- ==========================================
-- 3. INSERTION DES DONNÉES
-- ==========================================

-- Équipes (16 Clubs Botola)
INSERT INTO teams (id, name, logo_url) VALUES 
(1, 'Raja CA', 'images/teams/raja.png'),
(2, 'Wydad AC', 'images/teams/wydad.png'),
(3, 'AS FAR', 'images/teams/asfar.png'),
(4, 'RS Berkane', 'images/teams/berkane.png'),
(5, 'FUS Rabat', 'images/teams/fus.png'),
(6, 'MAS Fès', 'images/teams/mas.png'),
(7, 'Hassania Agadir', 'images/teams/husa.png'),
(8, 'Ittihad Tanger', 'images/teams/irt.png'),
(9, 'Olympique Safi', 'images/teams/ocs.png'),
(10, 'Moghreb Tétouan', 'images/teams/mat.png'),
(11, 'R. Zemamra', 'images/teams/rca.png'),
(12, 'Union Touarga', 'images/teams/uts.png'),
(13, 'JS Soualem', 'images/teams/jss.png'),
(14, 'Kawkab Marrakech', 'images/teams/kacm.png'), 
(15, 'COD Meknès', 'images/teams/codm.png'),
(16, 'Difaâ El Jadida', 'images/teams/dhj.png');

-- Joueurs (Top Players & Buteurs)
INSERT INTO players (team_id, name, position) VALUES 
(1, 'Yousri Bouzok', 'ATT'), (1, 'Adam Ennafati', 'ATT'), (1, 'Naoufel Zerhouni', 'ATT'),
(2, 'Niazi Sylla', 'ATT'), (2, 'Saifeddine Bouhra', 'ATT'), (2, 'Jamal Harkass', 'DEF'),
(3, 'Rabie Hrimat', 'MIL'), (3, 'Amine Zouhzouh', 'ATT'), (3, 'Khalid Ait Ouarkhane', 'MIL'),
(4, 'Youssef Mehri', 'ATT'), (4, 'Paul Valère Bassène', 'ATT'), (4, 'Dayo Issoufou', 'DEF'),
(5, 'Hamza Hannouri', 'ATT'), (5, 'Amine Azri', 'MIL'),
(6, 'Mouhcine Bouriga', 'ATT'),
(8, 'Ismail Khafi', 'ATT'), (8, 'Ali El Harrak', 'MIL'),
(9, 'Abdoulaye Diarra', 'ATT'),
(10, 'Pape Badji', 'ATT'),
(11, 'Zakaria Bahrou', 'ATT');

-- Admin par défaut (Mot de passe: "password")
INSERT INTO users (username, email, password, role) VALUES 
('Admin', 'admin@botola.ma', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- MATCHS JOUÉS (Passé)
INSERT INTO matches (home_team_id, away_team_id, home_score, away_score, match_date, status) VALUES 
(1, 2, 1, 1, NOW() - INTERVAL 20 DAY, 'played'), -- Raja 1-1 Wydad
(3, 4, 2, 0, NOW() - INTERVAL 20 DAY, 'played'), -- FAR 2-0 Berkane
(5, 6, 0, 0, NOW() - INTERVAL 20 DAY, 'played'), -- FUS 0-0 MAS
(7, 8, 1, 2, NOW() - INTERVAL 19 DAY, 'played'), -- HUSA 1-2 IRT
(2, 3, 0, 1, NOW() - INTERVAL 14 DAY, 'played'), -- Wydad 0-1 FAR
(4, 1, 1, 2, NOW() - INTERVAL 14 DAY, 'played'), -- Berkane 1-2 Raja
(1, 8, 3, 0, NOW() - INTERVAL 7 DAY, 'played'),  -- Raja 3-0 IRT
(3, 6, 2, 1, NOW() - INTERVAL 7 DAY, 'played');  -- FAR 2-1 MAS

-- MATCHS À VENIR (Futur - Dates corrigées pour l'affichage)
INSERT INTO matches (home_team_id, away_team_id, match_date, status) VALUES 
(1, 5, NOW() + INTERVAL 2 DAY, 'scheduled'),  -- Raja vs FUS
(2, 4, NOW() + INTERVAL 2 DAY, 'scheduled'),  -- Wydad vs Berkane
(3, 8, NOW() + INTERVAL 3 DAY, 'scheduled'),  -- FAR vs IRT
(6, 11, NOW() + INTERVAL 3 DAY, 'scheduled'), -- MAS vs RCA
(7, 13, NOW() + INTERVAL 4 DAY, 'scheduled'), -- HUSA vs JSS
(12, 10, NOW() + INTERVAL 5 DAY, 'scheduled'); -- UTS vs MAT

-- BUTS (Pour les stats)
INSERT INTO goals (match_id, player_id, minute) VALUES 
(1, 1, 23), (1, 4, 88), -- Raja vs Wydad
(2, 7, 12), (2, 8, 65), -- FAR vs Berkane
(7, 1, 12), (7, 2, 44), (7, 3, 76); -- Raja vs IRT

