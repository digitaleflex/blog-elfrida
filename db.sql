-- Création de la base de données
CREATE DATABASE IF NOT EXISTS blog;
USE blog;

-- Structure des tables
CREATE TABLE articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    contenu TEXT NOT NULL,
);

CREATE TABLE inscription (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR NOT NULL,
    prenom VARCHAR NOT NULL,
    username VARCHAR NOT NULL,
    password VARCHAR NOT NULL,
    confirm_password VARCHAR NOT NULL,
);

CREATE TABLE commentaires (
    id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT NOT NULL,
    comment VARCHAR NOT NULL,
    FOREIGN KEY (id) REFERENCES inscription(id)
);