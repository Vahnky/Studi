<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garage V.Parrot</title>

    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <link rel="icon" type="image/png" href="img/logo.png"/>
</head>
<body>
<header><?php require_once "navbar.php"?></header>

<div id=titre>
<br>
<h1>Bienvenue au Garage V.Parrot</h1>
<br><br>




</div>
<div class="serv">
<br>
<h2>NOS SERVICES :</h2>

<!-- //////////////////////////////////BDD DIFFERENTS SERVICES QU ON ENTRE A PARTIR D'ADMIN.PHP -->

<?php 

try{



    //on se connecte à mysql
    $pdo = new PDO("mysql:host=localhost;", 'root', '');

    $pdo->exec("CREATE DATABASE IF NOT EXISTS garage");

    //on lui dit qu'on veut utiliser cette base de données
    $pdo->exec("USE garage");
    //on crée la table dans laquelle on enregistrera les services proposés voulus
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS Services (
            id INT AUTO_INCREMENT PRIMARY KEY,
            service1 VARCHAR(255) NULL,
            service2 VARCHAR(255) NULL,
            service3 VARCHAR(255) NULL,
            service4 VARCHAR(255) NULL,
            service5 VARCHAR(255) NULL
        )
        ");
        //message d'erreur et arret du script si ca ne fonctionne pas
    }catch (PDOException $e) {
    die($e->getMessage());
}

//On met ca car il peut y avoir des problème de $_POST[serviceX] undefined
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $service1 = $service2 = $service3 = $service4 = $service5 = "";

    //On stocke dans des variables le texte entré par admin sur sa page

    $service1 = $_POST["service1"];

    
    $service2 = $_POST["service2"];

    $service3 = $_POST["service3"];

    
    $service4 = $_POST["service4"];

    
    $service5 = $_POST["service5"];

    try {
        //On prépare la requète qui est d'insérer les valeurs dans les colonnes
        $statement = $pdo->prepare("INSERT INTO Services (service1, service2, service3, service4, service5) VALUES (:service1, :service2, :service3, :service4, :service5);");
        $statement->bindParam(':service1', $service1);
        $statement->bindParam(':service2', $service2);
        $statement->bindParam(':service3', $service3);
        $statement->bindParam(':service4', $service4);
        $statement->bindParam(':service5', $service5);
        //On exécute
        $statement->execute();
        //en cas d'erreur
    } catch(PDOException $e) {
    $e->getMessage();
    }
}

//Maintenant que les données des services sont stockés dans la table

try {
    // On prépare la requète pour obtenir les valeurs rangées triés par id décroissant
    $statement = $pdo->prepare("SELECT * FROM Services ORDER BY id DESC");
    // on exécute
    $statement->execute();

    // on récupère les résultats
$result = $statement->fetch(PDO::FETCH_ASSOC);

if ($result) {
    // On les stockent dans des variables qu'on va pourvoir utiliser dans des div
    $service1 = $result['service1'];
    $service2 = $result['service2'];
    $service3 = $result['service3'];
    $service4 = $result['service4'];
    $service5 = $result['service5'];
} 

} catch(PDOException $e) {
    echo $e->getMessage();
}
?>


<!-- ///////////////////////////////////////////////////ON ECRIT LES DIFFERENTS SERVICES SUR LA PAGE -->

<div id="service1"><p class="index"><?php if(isset($service1)){echo $service1;} ?></p></div>
<div id="service2"><p class="index"><?php if(isset($service2)){echo $service2;} ?></p></div>
<div id="service3"><p class="index"><?php if(isset($service3)){echo $service3;} ?></p></div>
<div id="service4"><p class="index"><?php if(isset($service4)){echo $service4;} ?></p></div>
<div id="service5"><p class="index"><?php if(isset($service5)){echo $service5;} ?></p></div>






<br>

</div>

<div id="avis"> <br><h2>Les avis :</h2>

<!-- /////////////////////////////////////////////////////affichage des commentaires approuvés = approuve=1 -->

<?php
try{
    // On crée une nouvelle instance de pdo
    $pdo = new PDO('mysql:host=localhost;dbname=garage', 'root', '');

    // on vérifie si la table existe et si elle a au moins une ligne
    
    $result = $pdo->query("SHOW TABLES LIKE 'Commentaires'");
    
    if ($result->rowCount() > 0) {

        // on prépare la requete de sélectionner toutes les lignes avec les valeurs de la colonne approuve à 1

    $statement = $pdo->prepare("SELECT * FROM Commentaires WHERE approuve=1");

    $statement->execute();

    // on récupère toutes les lignes et on les mets dans un tableau associatif

    $avis= $statement->fetchAll(PDO::FETCH_ASSOC);

    // pour chacune de ces lignes on écrit le nom le commentaire et la note
    foreach($avis as $row) {
        echo '<p class="index">Nom: ' . $row["visitname"]. " - Commentaire: " . $row["commentaire"]. " - Note: " . $row["note"] ."</p><br><br>";
    }
} } catch(PDOException $e) {
    echo $e->getMessage();}
?>



<a href="commentaire.php" class="button"><p class="index">Cliquez ici pour laisser un avis<span class="material-symbols-outlined">
open_in_new
</span></p></a>



<br>

</div>
<footer><?php require_once "horaires.php"?></footer>

</body>
</html>

