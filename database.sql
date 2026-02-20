-- Base de données Librairie
-- Créer cette base de données MySQL

CREATE DATABASE IF NOT EXISTS librairie;
USE librairie;

-- Table des livres
CREATE TABLE IF NOT EXISTS livres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    auteur VARCHAR(255) NOT NULL,
    annee INT NOT NULL,
    prix DECIMAL(10, 2) NOT NULL,
    description TEXT,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_modification TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insérer quelques exemples de livres
INSERT INTO livres (titre, auteur, annee, prix, description) VALUES
('Le Petit Prince', 'Antoine de Saint-Exupéry', 1943, 9.99, 'Un conte poétique et philosophique'),
('1984', 'George Orwell', 1949, 12.99, 'Roman d''anticipation sur le totalitarisme'),
('Harry Potter à l\'école des sorciers', 'J.K. Rowling', 1997, 14.99, 'Premier tome de la série Harry Potter'),
('Les Misérables', 'Victor Hugo', 1862, 15.99, 'Roman dramatique sur la France du 19e siècle'),
('Le Lord des Anneaux', 'J.R.R. Tolkien', 1954, 19.99, 'Trilogie fantasy épique');

