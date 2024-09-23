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
    Grade ENUM('Affilié', 'Sympathisant', 'Adhérent', 'Chevalier / Dame', 'Grand Chevalier / Haute Dame', 'Commandeur', 'Grand \'Croix') NOT NULL,
    Rang ENUM('Novice', 'Compagnon'),
    Titre ENUM('Philanthrope', 'Protecteur', 'Honorable'),
    Dignite ENUM('Maitre', 'Grand Chancelier', 'Grand Maitre'),
    Structure_Id INT,
    FOREIGN KEY (Structure_Id) REFERENCES STRUCTURE(Id) ON DELETE SET NULL -- Modification de la contrainte : si la structure est supprimé, on met la valeur a NULL
);

-- Table REPAS
CREATE TABLE IF NOT EXISTS REPAS (
    Id INT PRIMARY KEY AUTO_INCREMENT,   -- Ajout de AUTO_INCREMENT pour faciliter lajout
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

-- Création des Index
CREATE INDEX idx_code_personnel ON TENRAC(Code_personnel);
CREATE INDEX idx_nom_plat ON PLAT(Nom);
CREATE INDEX idx_nom_repas ON REPAS(Nom);
CREATE INDEX idx_email_tenrac ON TENRAC(Email);

-- Création des Triggers

-- Trigger pour mettre à jour la structure si un club est supprimé
CREATE TRIGGER trg_update_tenrac_structure
BEFORE DELETE ON STRUCTURE
FOR EACH ROW
BEGIN
    IF OLD.Type = 'Club' THEN
        UPDATE TENRAC
        SET Structure_Id = (SELECT Id FROM STRUCTURE WHERE Type = 'Ordre')
        WHERE Structure_Id = OLD.Id;
    END IF;
END;

-- Trigger pour hacher les mots de passe avant l'insertion dans AUTHENTIFICATION
CREATE TRIGGER trg_hash_password
BEFORE INSERT ON AUTHENTIFICATION
FOR EACH ROW
BEGIN
    SET NEW.Password = SHA2(NEW.Password, 256);  -- Exemple de hachage avec SHA-256
END;

-- Trigger pour vérifier qu'un repas a au moins un Chevalier/Dame
CREATE TRIGGER trg_check_chevalier_presence
BEFORE INSERT ON REPAS_PARTICIPANT
FOR EACH ROW
BEGIN
    DECLARE chevalierCount INT;
    
    SELECT COUNT(*)
    INTO chevalierCount
    FROM TENRAC t
    WHERE t.Id = NEW.Tenrac_Id
      AND t.Grade IN ('Chevalier / Dame', 'Grand Chevalier / Haute Dame', 'Commandeur', 'Grand \'Croix');
    
    IF chevalierCount = 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Un repas doit avoir au moins un Chevalier/Dame ou supérieur.';
    END IF;
END;

-- Trigger pour mettre à jour les participations lors de la suppression d'un repas
CREATE TRIGGER trg_delete_repas_participant
AFTER DELETE ON REPAS
FOR EACH ROW
BEGIN
    DELETE FROM REPAS_PARTICIPANT WHERE Repas_Id = OLD.Id;
END;

-- Trigger pour vérifier que le grade est cohérent avec le rang
CREATE TRIGGER trg_check_grade_rang
BEFORE UPDATE ON TENRAC
FOR EACH ROW
BEGIN
    IF NEW.Grade = 'Chevalier / Dame' AND NEW.Rang != 'Compagnon' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Un Chevalier / Dame doit avoir le rang Compagnon.';
    END IF;
END;

-- Trigger pour l'ajout d'un tenrac dans le journal LOGS
CREATE TRIGGER trg_log_insert_tenrac
AFTER INSERT ON TENRAC
FOR EACH ROW
BEGIN
    INSERT INTO LOGS (Action, Tenrac_Id)
    VALUES ('INSERT', NEW.Id);
END;

-- Trigger pour la suppression d'un tenrac dans le journal LOGS
CREATE TRIGGER trg_log_delete_tenrac
AFTER DELETE ON TENRAC
FOR EACH ROW
BEGIN
    INSERT INTO LOGS (Action, Tenrac_Id)
    VALUES ('DELETE', OLD.Id);
END;

-- Création des Procédures stockées

-- Procédure pour ajouter un repas avec des plats et des participants
DELIMITER //
CREATE PROCEDURE AddRepasWithPlats (
    IN repasNom VARCHAR(100),
    IN repasDate DATE,
    IN repasAdresse VARCHAR(255),
    IN plats JSON,  -- Liste de plats en format JSON
    IN participants JSON -- Liste de participants (ids des tenracs)
)
BEGIN
    DECLARE newRepasId INT;
    
    INSERT INTO REPAS (Nom, Datee, Adresse)
    VALUES (repasNom, repasDate, repasAdresse);
    
    SET newRepasId = LAST_INSERT_ID();
    
    DECLARE platNom VARCHAR(100);
    FOR platNom IN (SELECT JSON_UNQUOTE(JSON_EXTRACT(plats, '$[*]')))
    DO
        INSERT INTO PLAT (Repas_Id, Nom) VALUES (newRepasId, platNom);
    END FOR;
    
    DECLARE tenracId INT;
    FOR tenracId IN (SELECT JSON_UNQUOTE(JSON_EXTRACT(participants, '$[*]')))
    DO
        INSERT INTO REPAS_PARTICIPANT (Repas_Id, Tenrac_Id) VALUES (newRepasId, tenracId);
    END FOR;
END //
DELIMITER ;

-- Procédure pour récupérer les détails d'un tenrac
DELIMITER //
CREATE PROCEDURE GetTenracDetails (IN tenracId INT)
BEGIN
    SELECT t.Nom, t.Email, t.Grade, t.Rang, t.Titre, t.Dignite, s.Nom AS Structure
    FROM TENRAC t
    LEFT JOIN STRUCTURE s ON t.Structure_Id = s.Id
    WHERE t.Id = tenracId;
END //
DELIMITER ;

-- Procédure pour récupérer tous les repas auxquels un tenrac a participé
DELIMITER //
CREATE PROCEDURE GetRepasForTenrac (IN tenracId INT)
BEGIN
    SELECT r.Nom AS Repas, r.Datee, r.Adresse
    FROM REPAS r
    JOIN REPAS_PARTICIPANT rp ON r.Id = rp.Repas_Id
    WHERE rp.Tenrac_Id = tenracId;
END //
DELIMITER ;

-- Procédure pour ajouter un nouveau tenrac avec des vérifications sur l'email
DELIMITER //
CREATE PROCEDURE AddTenrac (
    IN code_personnel VARCHAR(20),
    IN nom VARCHAR(50),
    IN email VARCHAR(100),
    IN numero VARCHAR(15),
    IN adresse VARCHAR(255),
    IN grade ENUM('Affilié', 'Sympathisant', 'Adhérent', 'Chevalier / Dame', 'Grand Chevalier / Haute Dame', 'Commandeur', 'Grand \'Croix'),
    IN rang ENUM('Novice', 'Compagnon'),
    IN titre ENUM('Philanthrope', 'Protecteur', 'Honorable'),
    IN dignite ENUM('Maitre', 'Grand Chancelier', 'Grand Maitre'),
    IN structureId INT
)
BEGIN
    DECLARE emailCount INT;
    
    SELECT COUNT(*)
    INTO emailCount
    FROM TENRAC
    WHERE Email = email;
    
    IF emailCount > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Un membre avec cet email existe déjà.';
    ELSE
        INSERT INTO TENRAC (Code_personnel, Nom, Email, Numero, Adresse, Grade, Rang, Titre, Dignite, Structure_Id)
        VALUES (code_personnel, nom, email, numero, adresse, grade, rang, titre, dignite, structureId);
    END IF;
END //
DELIMITER ;

-- Procédure pour lister les plats contenant au moins un légume
DELIMITER //
CREATE PROCEDURE GetPlatsWithLegumes ()
BEGIN
    SELECT p.Nom AS Plat, i.Nom AS Ingredient
    FROM PLAT p
    JOIN PLATS_INGREDIENTS pi ON p.Id = pi.Plat_Id
    JOIN INGREDIENTS i ON pi.Ingredient_Id = i.Id
    WHERE i.Est_legume = TRUE;
END //
DELIMITER ;