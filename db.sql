-- Création de la base de données avec encodage UTF-8 pour supporter les caractères spéciaux
CREATE DATABASE IF NOT EXISTS blogg 
    CHARACTER SET utf8mb4 
    COLLATE utf8mb4_unicode_ci;
USE blogg;

-- Table des articles avec date de création et statut
CREATE TABLE articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,           -- Limite raisonnable pour un titre
    contenu TEXT NOT NULL,                 -- Correction : virgule ajoutée dans le code original
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP, -- Date automatique de création
    statut ENUM('brouillon', 'publié') DEFAULT 'brouillon' -- Gestion de l'état de l'article
);

-- Table des utilisateurs (remplace "inscription" pour une meilleure sémantique)
CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,            -- Longueur adaptée pour les noms
    prenom VARCHAR(100) NOT NULL,         -- Longueur adaptée pour les prénoms
    username VARCHAR(50) NOT NULL,        -- Correction : longueur spécifiée
    email VARCHAR(255) NOT NULL,          -- Ajout d'un champ email essentiel
    password VARCHAR(255) NOT NULL,       -- Longueur pour hash sécurisé (ex: bcrypt)
    date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP, -- Traçabilité
    CONSTRAINT uc_username UNIQUE (username), -- Username unique
    CONSTRAINT uc_email UNIQUE (email)    -- Email unique
    -- Correction : confirm_password supprimé car inutile dans la BD
);

-- Table des commentaires avec références correctes
CREATE TABLE commentaires (
    id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT NOT NULL,              -- Référence à l'article
    utilisateur_id INT NOT NULL,          -- Référence à l'utilisateur (auteur du commentaire)
    contenu TEXT NOT NULL,                -- Correction : "comment" renommé en "contenu" pour cohérence
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP, -- Date du commentaire
    FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE,    -- Correction : référence à articles
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE -- Lien avec utilisateurs
);