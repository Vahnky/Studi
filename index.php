<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garage V.Parrot</title>

    <link rel="stylesheet" href="style/style.css">

    

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <link rel="icon" type="image/png" href="img/logo.png"/>

    <meta name="auteur" content="Vahnky" />

    <meta
  name="description"
  content="Garage V.Parrot" />
  
</head>
<body>
<header><?php require_once "php/navbar.php"?></header>

<div id=titre>
<br>
<section class="principale1">
<h1>Bienvenue au Garage V.Parrot</h1>
<div class="flex">
<h2 class="principale">Votre voiture entre de bonnes mains!</h2>
</div>
</section>
<br><br>




</div>
<div class="serv">
<br>
<h2>NOS SERVICES :</h2>

<!-- //////////////////////////////////BDD DIFFERENTS SERVICES QU ON ENTRE A PARTIR D'ADMIN.PHP -->

<?php 

try{



    require_once("php/pdo.php");

    //on lui dit qu'on veut utiliser cette base de données

    //on crée la table dans laquelle on enregistrera les services proposés voulus
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS services (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NULL,
            descr TEXT,
            imageserv VARCHAR(255) NULL
        )
        ");
        //message d'erreur et arret du script si ca ne fonctionne pas
    }catch (PDOException $e) {
    die($e->getMessage());
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['servi'])) {

    if(isset($_POST['titreservice'])){$serviceTitle = $_POST['titreservice'];}
    if(isset($_POST['descrservice'])){$serviceText = $_POST['descrservice'];}
    if (isset($_FILES['imageserv'])) {
        // On récup le nom du fichier et on le stocke dans une variable
        $imageserv = $_FILES['imageserv']['name'];
        // On récupère le type mime du fichier et on le stocke dans $image_type
        $image_type = $_FILES['imageserv']['type'];
    
        // Vérification du type MIME : si il n'est pas du type jpeg, jpg, png
        if (!in_array($image_type, ['image/jpeg', 'image/jpg', 'image/png'])) {
            echo "<p class='fcont'>L'upload n'a pas fonctionné. Les fichiers doivent être de type jpg, jpeg ou png.</p>";
    
            exit;
        }
    
        //Si le type est bon, on définit le chemin de destination pour enregistrer le fichier dans le dossier img/.
    
        $target = "img/" . basename($imageserv);
    
        // On déplace le fichier vers le chemin qu'on vient de créer
        move_uploaded_file($_FILES['imageserv']['tmp_name'], $target);
    }

    // Préparer la requête SQL
    $sql = "INSERT INTO services (title, descr, imageserv) VALUES (:title, :descr, :imageserv)";
    $stmt = $pdo->prepare($sql);

    // Lier les paramètres
    $stmt->bindParam(':title', $serviceTitle);
    $stmt->bindParam(':descr', $serviceText);
    $stmt->bindParam(':imageserv', $imageserv);

    // Exécuter la requête
    $stmt->execute();

}




?>

<div class="containerserv">

<?php
//Maintenant que les données des services sont stockés dans la table

try {
    // On prépare la requète pour obtenir les valeurs rangées triés par id décroissant
    $sql = "SELECT title, descr, imageserv FROM services";
    $stmt = $pdo->query($sql);


    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        $title = $row['title'];
        $descr = $row['descr'];
        $image = $row['imageserv'];
    
        echo "<div class='service-item'>";

        echo "<img class='imgserv' src='img/$image' alt='Service Image'>";

        echo "<div class='service-txt'>";

        echo "<h3 class='service-title'>$title</h3>";
        echo "<div class='service-descr'>$descr</div>";

        echo "</div>";

        echo "</div>";
    }}
    catch(PDOException $e) {
        echo $e->getMessage();
    }
?>





</div>




<br>

</div>

<div id="avis"> <br><h2>Les avis :</h2>

<!-- /////////////////////////////////////////////////////affichage des commentaires approuvés = approuve=1 -->

<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">

    <?php

    try {

        $result = $pdo->query("SHOW TABLES LIKE 'Commentaires'");

        if ($result->rowCount() > 0) {

            $statement = $pdo->prepare("SELECT * FROM Commentaires WHERE approuve=1");
            $statement->execute();

            $avis = $statement->fetchAll(PDO::FETCH_ASSOC);

            foreach ($avis as $row) {

                echo '<div class="carousel-item' . ($row["visitname"] === $avis[0]["visitname"] ? ' active' : '') . '">';

                echo '<p class="indexx">Nom: ' . $row["visitname"] . "<br> Commentaire: " . $row["commentaire"] . "<br> Note: " . $row["note"] . "/10" . "</p>";
                
                echo '</div>';
            }
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    ?>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>





<br>

</div>
<?php require_once "php/horaires.php"?>
<?php require_once "php/footer.php"?>

</body>
</html>

