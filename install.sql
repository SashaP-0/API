CREATE DATABASE IF NOT EXISTS recipieDB;
USE recipieDB;



CREATE TABLE tblrecipies (
    recipieID INT AUTO_INCREMENT PRIMARY KEY,
    recipiename VARCHAR(255) NOT NULL,
    cookingtime INT NOT NULL,
    favorites BOOLEAN DEFAULT FALSE,,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE tblingredients (
    ingredientID INT AUTO_INCREMENT PRIMARY KEY,
    ingredientname VARCHAR(255) NOT NULL UNIQUE,
    storageID INT,
    staple BOOLEAN DEFAULT FALSE,
    CONSTRAINT keys_storage
        FOREIGN KEY (storageID)
        REFERENCES tblstorage(storageID)
        ON DELETE SET NULL
        ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE tblstorage (
    storageID INT AUTO_INCREMENT PRIMARY KEY,
    storagetype VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE tbllinkrecipies (
    recipieID INT NOT NULL,
    ingredientID INT NOT NULL,
    quantperportion DECIMAL(10,2) NOT NULL,
    unit VARCHAR(50) NOT NULL,
    isoptional BOOLEAN DEFAULT FALSE,
    PRIMARY KEY (recipieID, ingredientID),
    CONSTRAINT key_recipe
        FOREIGN KEY (recipieID)
        REFERENCES tblrecipies(recipieID)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT key_ingredient
        FOREIGN KEY (ingredientID)
        REFERENCES tblingredients(ingredientID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;


CREATE TABLE tblinstructions (
    recipieID INT NOT NULL,
    instructionno INT NOT NULL,
    instruction TEXT NOT NULL,
    PRIMARY KEY (recipieID, instructionno),
    CONSTRAINT key_instruction_recipe
        FOREIGN KEY (recipieID)
        REFERENCES tblrecipies(recipieID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE tbllinkreqs (
    recipieID INT NOT NULL,
    reqID INT NOT NULL,
    PRIMARY KEY (recipieID, reqID),
    CONSTRAINT key_lreq_recipe
        FOREIGN KEY (recipieID)
        REFERENCES tblrecipies(recipieID)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT key_lreq_req
        FOREIGN KEY (reqID)
        REFERENCES tbldietryreqs(reqID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE tbldietryreqs (
    reqID INT AUTO_INCREMENT PRIMARY KEY,
    reqname VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE useringredients (
    userID INT NOT NULL,
    ingredientID INT NOT NULL,
    offdate DATE,
    PRIMARY KEY (userID, ingredientID),
    CONSTRAINT key_ui_user
        FOREIGN KEY (userID)
        REFERENCES tblusers(userID)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT key_ui_ingredient
        FOREIGN KEY (ingredientID)
        REFERENCES tblingredients(ingredientID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE tblusers (
    userID INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    passwordhash VARCHAR(255) NOT NULL,
) ENGINE=InnoDB;


