USE `martin-chicken_db`;

-- Supp table 
DROP TABLE IF EXISTS STRUCTURE;
DROP TABLE IF EXISTS TENRAC;
DROP TABLE IF EXISTS REPAS;
DROP TABLE IF EXISTS PLAT;
DROP TABLE IF EXISTS SAUCES;
DROP TABLE IF EXISTS INGREDIENTS;
DROP TABLE IF EXISTS REPAS_PARTICIPANT;
DROP TABLE IF EXISTS PLATS_INGREDIENTS;
DROP TABLE IF EXISTS PLATS_SAUCES;
DROP TABLE IF EXISTS AUTHENTIFICATION;

-- Création des table

-- Table STRUCTURE (Ordre et clubs)
CREATE TABLE IF NOT EXISTS STRUCTURE (
    Id INT PRIMARY KEY AUTO_INCREMENT,   -- Ajout de AUTO_INCREMENT pour faciliter l'ajout
    Type ENUM('Ordre', 'Club') NOT NULL,
    Nom VARCHAR(50) NOT NULL,            
    Adresse VARCHAR(255) NOT NULL        
);

-- Table TENRAC (membres)
CREATE TABLE IF NOT EXISTS TENRAC (
    Id INT PRIMARY KEY AUTO_INCREMENT,   -- Ajout de AUTO_INCREMENT pour faciliter l'ajout
    Code_personnel VARCHAR(20) UNIQUE NOT NULL, -- Nouveau champ pour le code personnel unique des membres
    Nom VARCHAR(50) NOT NULL,           
    Email VARCHAR(100) NOT NULL,         
    Numero VARCHAR(15),                  
    Adresse VARCHAR(255),                
    Grade ENUM('Affilié', 'Sympathisant', 'Adhérent', 'Chevalier / Dame', 'Grand Chevalier / Haute Dame', 'Commandeur', 'Grand\'Croix') NOT NULL,
    Rang ENUM('Novice', 'Compagnon'),
    Titre ENUM('Philanthrope', 'Protecteur', 'Honorable'),
    Dignite ENUM('Maitre', 'Grand Chancelier', 'Grand Maitre'),
    Structure_Id INT,
    FOREIGN KEY (Structure_Id) REFERENCES STRUCTURE(Id) ON DELETE SET NULL -- Modification de la contrainte : si la structure est supprimé, on met la valeur a NULL
);

-- Table REPAS
CREATE TABLE IF NOT EXISTS REPAS (
    Id INT PRIMARY KEY AUTO_INCREMENT,   -- Ajout de AUTO_INCREMENT pour faciliter l'ajout
    Nom VARCHAR(100) NOT NULL,           
    Datee DATE NOT NULL,
    Adresse VARCHAR(255) NOT NULL,       
    Presence BOOLEAN NOT NULL DEFAULT FALSE
);

-- Table PLAT
CREATE TABLE IF NOT EXISTS PLAT (
    Id INT PRIMARY KEY AUTO_INCREMENT,   -- Ajout de AUTO_INCREMENT pour faciliter l'ajout
    Repas_Id INT NOT NULL,
    Nom VARCHAR(100) NOT NULL,           
    FOREIGN KEY (Repas_Id) REFERENCES REPAS(Id) ON DELETE CASCADE -- Suppression en cascade si le repas est supprimé
);

-- Table INGREDIENTS (avec gestion des légumes)
CREATE TABLE IF NOT EXISTS INGREDIENTS (
    Id INT PRIMARY KEY AUTO_INCREMENT,   -- Ajout de AUTO_INCREMENT pour faciliter l'ajout
    Nom VARCHAR(100) NOT NULL,           
    Est_legume BOOLEAN NOT NULL DEFAULT FALSE -- Champ pour spécifier si l'ingrédient est un légume
);

-- Table SAUCES
CREATE TABLE IF NOT EXISTS SAUCES (
    Id INT PRIMARY KEY AUTO_INCREMENT,   -- Ajout de AUTO_INCREMENT pour faciliter l'ajout
    Nom VARCHAR(100) NOT NULL            
);

-- Table de participation aux repas (relation N:N entre TENRAC et REPAS)
CREATE TABLE IF NOT EXISTS REPAS_PARTICIPANT (
    Repas_Id INT NOT NULL,
    Tenrac_Id INT NOT NULL,
    PRIMARY KEY (Repas_Id, Tenrac_Id),
    FOREIGN KEY (Repas_Id) REFERENCES REPAS(Id) ON DELETE CASCADE, -- Suppression en cascade
    FOREIGN KEY (Tenrac_Id) REFERENCES TENRAC(Id) ON DELETE CASCADE -- Suppression en cascade
);

-- Table de relation entre plats et ingrédients (relation N:N)
CREATE TABLE IF NOT EXISTS PLATS_INGREDIENTS (
    Plat_Id INT NOT NULL,
    Ingredient_Id INT NOT NULL,
    PRIMARY KEY (Plat_Id, Ingredient_Id),
    FOREIGN KEY (Plat_Id) REFERENCES PLAT(Id) ON DELETE CASCADE,   -- Suppression en cascade
    FOREIGN KEY (Ingredient_Id) REFERENCES INGREDIENTS(Id) ON DELETE CASCADE -- Suppression en cascade
);

-- Table de relation entre plats et sauces (relation N:N)
CREATE TABLE IF NOT EXISTS PLATS_SAUCES (
    Plat_Id INT NOT NULL,
    Sauce_Id INT NOT NULL,
    PRIMARY KEY (Plat_Id, Sauce_Id),
    FOREIGN KEY (Plat_Id) REFERENCES PLAT(Id) ON DELETE CASCADE,   -- Suppression en cascade
    FOREIGN KEY (Sauce_Id) REFERENCES SAUCES(Id) ON DELETE CASCADE -- Suppression en cascade
);

-- Table AUTHENTIFICATION pour gérer la connexion des utilisateurs
CREATE TABLE IF NOT EXISTS AUTHENTIFICATION (
    Id INT PRIMARY KEY AUTO_INCREMENT,   -- Ajout de AUTO_INCREMENT pour faciliter l'ajout
    Tenrac_Id INT UNIQUE NOT NULL,        -- Chaque membre a un compte unique relier à la table TENRAC
    Username VARCHAR(50) UNIQUE NOT NULL, -- Champ pour le nom d'utilisateur unique
    Password VARCHAR(255) NOT NULL,       -- Mot de passe pour l'authentification
    FOREIGN KEY (Tenrac_Id) REFERENCES TENRAC(Id) ON DELETE CASCADE -- Suppression en cascade si le membre est supprimé
);

