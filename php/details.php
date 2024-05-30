<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garage V.Parrot</title>

    <link rel="stylesheet" href="../style/style.css">


    <link rel="icon" type="image/png" href="img/logo.png"/>
</head>
<body>
<header><?php require_once "navbar.php"?></header>

<div class="det">

<?php
require_once("pdo.php"); 


if (isset($_GET['id'])) {
    $voitureId = $_GET['id'];
    $statement = $pdo->prepare("SELECT * FROM Voitures WHERE id = :id");
    $statement->execute(['id' => $voitureId]);
    $voiture = $statement->fetch(PDO::FETCH_ASSOC);

    if ($voiture) {
        echo "<h1>Détails de la voiture</h1>";
        echo "<div class='detdet'>";
        echo "<p>Marque : " . $voiture['marque'] . "</p>";
        echo "<p>Prix : " . $voiture['prix'] . "</p>";
        echo "<p>Année de mise en circulation : " . $voiture['annee'] . "</p>";
        echo "<p>Caractéristiques : " . $voiture['caracteristiques'] . "</p>";
        echo "<p>Equipements : " . $voiture['equipements'] . "</p>";
        echo "</div>";


        $voit = explode(',', $voiture['galerie_images']);

        echo "<div id='carouselExampleControls' class='carousel slide' data-ride='carousel'>";
        echo "<div class='carousel-inner'>";

        foreach ($voit as $index => $voitureImage) {

            $activeClass = ($index === 0) ? 'active' : '';

            echo "<div class='carousel-item $activeClass'>";

            echo "<img class='d-block w-100' src='img/$voitureImage' alt='Image de la voiture'>";

            echo "</div>";
        }

        echo "</div>";

        echo "<a class='carousel-control-prev' href='#carouselExampleControls' role='button' data-slide='prev'>";

        echo "<span class='carousel-control-prev-icon' aria-hidden='true'></span>";

        echo "<span class='sr-only'>Précédent</span>";

        echo "</a>";

        echo "<a class='carousel-control-next' href='#carouselExampleControls' role='button' data-slide='next'>";

        echo "<span class='carousel-control-next-icon' aria-hidden='true'></span>";

        echo "<span class='sr-only'>Suivant</span>";

        echo "</a>";
        echo "</div>"; 

    } else {
        echo "Voiture non trouvée.";
    }
} else {
    echo "ID de voiture manquant.";
}
?>











<div class='bottom'>
        <br>
    <h3>Nous contacter au sujet de cette voiture :</h3>

    <form action="contactlogic.php" method="post" id="formcont">

    <div id="ligne1">
            
    <div id="nomcontacte"><p class="formtur">Votre nom :</p>
            <input type="text" class="aa" id="nom" name="nom" required></div>


<div id="prénomcontacte"><p class="formtur">Votre prénom : </p>
            <input type="text" class="aa" id="prenom" name="prenom" required></div>

    <div id="emailcontacte"><p class="formtur">Votre email : </p>
            <input type="mail" class="aa" id="email" name="email" required></div>


    <div id="phonecontacte"><p class="formtur">Votre numéro de téléphone : </p>
            <input type="tel" class="aa" id="phone" name="phone"  required></div>


    </div>
    <div id="ligne2">
            <div id="titrecontacte"><p class="formtur">Titre du message : </p>
            
            <?php
echo '<input type="text" class="cc" id="titra" name="titre" value="Contact pour la ' . $voiture["marque"] . ' de référence ' . $voiture["id"] . ' prix :' . $voiture["prix"] . '." required>';
?>


            <div id="commentairecontacte"><p class="formtur">Votre message :</p>
    <textarea id="messagess" class="aa" name="messages" required></textarea></div>


          
            
        <div class="c100" id="submit">
            <input type="submit" class="bb" value="Envoyer"></div>
    </form>

        </div>

        </div>
    </div>
    <br><hr><br>
    </div>

    <?php require_once "footer.php"?>
        <script>redirect("formcont","okmess.php");</script>
