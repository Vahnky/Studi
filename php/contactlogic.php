<!DOCTYPE html>


<?php

// //////////////////////////////////////CREATION DE LA BDD Mess, de la table Messagess dans laquelle le prenom, email, phone, titre, messages seront stockés
// //////////////////////////////////////utilisée dans admin.php


try{
    // on crée une nouvelle instance de pdo
    require_once("pdo.php");



// on crée la table Messagess
$pdo->exec("
        CREATE TABLE IF NOT EXISTS Messagess (
            idmess INT AUTO_INCREMENT PRIMARY KEY,
            nom VARCHAR(255) NULL,
            prenom VARCHAR(255) NULL,
            email VARCHAR(255) NULL,
            phone VARCHAR(20) NULL,
            titre VARCHAR(255) NULL,
            messages LONGTEXT NULL

        )
        ");
        //message d'erreur et arret du script si ca ne fonctionne pas
    }catch (PDOException $e) {
    die($e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ////////////////////On fait ca et en dessous encore on utilise isset pour éviter les undefined array

    $nom = $prénom = $email = $phone = $titre = $messages = "";

    // ///////////////////////on stocke les valeurs des champs dans des variables,en se protégeant avec htmlentities, si elles sont renseignées
    
    if (isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["email"])  && isset($_POST["phone"])&& isset($_POST["titre"])  && isset($_POST["messages"])) {
        $nom = htmlentities($_POST["nom"]);
        $prenom = htmlentities($_POST["prenom"]);
        $email = htmlentities($_POST["email"]);
        $phone = htmlentities($_POST["phone"]);
        $titre = htmlentities($_POST["titre"]);
        $messages = htmlentities($_POST["messages"]);


        // ///////////////On prépare puis exécute la requete de mettre dans chaque colonne de la table Messagess les valeurs précédement stockés dans les variables 
    
        try {
            $statement = $pdo->prepare("INSERT INTO Messagess (nom, prenom, email, phone, titre, messages) VALUES (:nom, :prenom, :email, :phone, :titre, :messages);");

            // on bind les values
            $statement->bindParam(':nom', $nom);
            $statement->bindParam(':prenom', $prenom);
            $statement->bindParam(':email', $email);
            $statement->bindParam(':phone', $phone);
            $statement->bindParam(':titre', $titre);
            $statement->bindParam(':messages', $messages);
            // on exécute
            $statement->execute();
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    
}
    
?>
