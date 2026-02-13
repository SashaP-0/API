<?php

$host = "localhost";
$username = "root";
$password = "";
$dbname = "recipieDB";

try {
    // Connect to MySQL 
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create Database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    $pdo->exec("USE $dbname");

    // STORAGE TABLE 
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS tblstorage (
            storageID INT AUTO_INCREMENT PRIMARY KEY,
            storagetype VARCHAR(100) NOT NULL UNIQUE
        ) ENGINE=InnoDB;
    ");

    // USERS TABLE 
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS tblusers (
            userID INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(100) NOT NULL UNIQUE,
            email VARCHAR(255) NOT NULL UNIQUE,
            passwordhash VARCHAR(255) NOT NULL
        ) ENGINE=InnoDB;
    ");

    // DIETARY REQUIREMENTS
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS tbldietryreqs (
            reqID INT AUTO_INCREMENT PRIMARY KEY,
            reqname VARCHAR(100) NOT NULL UNIQUE
        ) ENGINE=InnoDB;
    ");

    // RECIPES
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS tblrecipies (
            recipieID INT AUTO_INCREMENT PRIMARY KEY,
            recipiename VARCHAR(255) NOT NULL,
            cookingtime INT NOT NULL,
            favorites BOOLEAN DEFAULT FALSE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB;
    ");

    // INGREDIENTS
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS tblingredients (
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
    ");

    // RECIPE => INGREDIENT LINK
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS tbllinkrecipies (
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
    ");

    // INSTRUCTIONS
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS tblinstructions (
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
    ");

    // RECIPE => DIET LINK
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS tbllinkreqs (
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
    ");

    // USER INGREDIENTS
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS useringredients (
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
    ");

    echo "Database and tables created successfully!";

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

?>
