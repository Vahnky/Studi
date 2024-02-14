

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garage V.Parrot</title>
    <link rel="shortcut icon" href="#" />
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="img/logo.png"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />


</head>

<header><?php require_once "navbar.php"?></header>

<body>



<div class="filtr">
<br>
<h2 class="cach2">Filtres :</h2>
<br>

<button class="accordeon"><p class="formvoit">Filtres</p></button>
<div class="panel">

<!-- //////////////////////////////////////// On crée notre formulaire pour filtrer les voitures proposés-->

<form id="filtrage">

    <div class="pair">
    <div class="uno"><p class = "formvoit">Prix minimum </p><input type="range" id="min-prix-range" name="min-prix-range" min="0" max="100000" step="100">
    <input type="number" id="min-prix" name="min-prix" min="0" max="100000" step="100"></div>
    <div class="uno"><div class="max"><p class = "formvoit">Prix maximum </p><input type="range" id="max-prix-range" name="max-prix-range" min="0" max="100000" step="100">
    <input type="number" id="max-prix" name="max-prix" min="0" max="100000" step="100"></div></div>
    </div>

    <div class="pair">
    <div class="uno"><p class = "formvoit">Kilométrage minimum </p><input type="range" id="min-kilometrage-range" name="min-kilometrage-range" min="0" max="500000" step="1000">
    <input type="number" id="min-kilometrage" name="min-kilometrage" min="0" max="500000" step="1000"></div>
    <div class="uno"><div class="max"><div class="milieubas"><p class = "formvoit">Kilométrage maximum</p><input type="range" id="max-kilometrage-range" name="max-kilometrage-range" min="0" max="500000" step="1000">
    <input type="number" id="max-kilometrage" name="max-kilometrage" min="0" max="500000" step="1000"></div></div></div>
    </div>

    <div class="pair">
    <div class="uno"><p class = "formvoit">Année minimum </p><input type="range" id="min-annee-range" name="min-annee-range" min="1950" max="2024">
    <input type="number" id="min-annee" name="min-annee" min="1950" max="2024"></div>
    <div class="uno"><div class="max"><p class = "formvoit">Année maximum </p><input type="range" id="max-annee-range" name="max-annee-range" min="1950" max="2024">
    <input type="number" id="max-annee" name="max-annee" min="1950" max="2024"></div></div>
    </div>

</form>

</div>
</div>

<!-- //////////////////////////////On crée un script pour gérer l'accordeon -->

<script>

    // On récupère les éléments html avec la classe accordion et on la stocke dans une variable, on crée une variable i
const accord = document.getElementsByClassName("accordeon");

    // //Si l'élémment est clické...
  accord[0].addEventListener("click", function() {
    // On stocke l'élément html suivant dans une variable
    let panel = this.nextElementSibling;
    // Si au click l'élément est déja affiché on le cache, sinon on l'affiche
    if (panel.style.display === "block") {
      panel.style.display = "none";
    } else {
      panel.style.display = "block";
    }
  });

</script>


<script>

// //////////////////////////////////////////On fait en sorte que l'input de type number = input de type range pour que les valeurs se suivent

// ////////////////On crée une fonction syncValues qui prend en argument les futurs input de type number et range
    const syncValues = (input1, input2) => {
        // /////////////////////   l'attribut oninput est l'évènement d'une modification, qui va faire en sorte que les valeurs des 2 inputs soient = quand une se modifie l'autre aussi
        input1.oninput = () => input2.value = input1.value;
        input2.oninput = () => input1.value = input2.value;
    };

    // On applique cela à tous nos inputs
    syncValues(document.getElementById('min-prix'), document.getElementById('min-prix-range'));
    syncValues(document.getElementById('max-prix'), document.getElementById('max-prix-range'));
    syncValues(document.getElementById('min-kilometrage'), document.getElementById('min-kilometrage-range'));
    syncValues(document.getElementById('max-kilometrage'), document.getElementById('max-kilometrage-range'));
    syncValues(document.getElementById('min-annee'), document.getElementById('min-annee-range'));
    syncValues(document.getElementById('max-annee'), document.getElementById('max-annee-range'));
</script>






<!-- ////////////////////////////////////////////////////On affiche les voitures en se connectant à la base de données cars, table Voitures créés dans employe.php -->

<div class="vtur">
<br>
<h2>Nos voitures :</h2>
<br>
<?php

// /////////////////////////////////////////On se co à la BDD et on vérifie si la table Voitures existe et on stocke ses infos dans une variable
$pdo = new PDO('mysql:host=localhost;', 'root', '');

$pdo->exec("CREATE DATABASE IF NOT EXISTS garage");

$pdo->exec("USE garage");

$statement = $pdo->prepare("SHOW TABLES LIKE 'Voitures'");
$statement->execute();
$resultverif = $statement->fetchAll();

// ////////////////////////////////////////Si notre variable n'est pas nulle, on récupère les données de la table sous forme de tableau associatif
if (count($resultverif) > 0) {
    $statement = $pdo->prepare("SELECT * FROM Voitures");
    $statement->execute();
    $voitures = $statement->fetchAll(PDO::FETCH_ASSOC);

    // On parcourt tous les éléments du tableau et on les affiche sous forme html

    foreach ($voitures as $voiture) {
        echo "<div class='voiture'>";
        echo "<div class='left'>";

        if (isset($voiture['image_principale'])){echo "<img src='img/" . $voiture['image_principale'] . "'><br>";}

        echo"<div id='flexpetit'>";
        if (isset($voiture['galerie_images'])) {
            echo "<div class='petitesimg'><a href='galerie.php?id=" . $voiture['id'] . "' target='_blank' class='button'><p class='galerie'>Voir la galerie d'images<span class='material-symbols-outlined'>
            open_in_new
            </span></p></a></div>";
        }
        
        echo "</div>";
        echo "</div>";

        echo "<div class='right'>";

        if(isset($voiture['marque'])){echo "<p class='tur'>Marque: <span class='marque'>" . $voiture['marque'] . "</p></span><br>";}
        if (isset($voiture['prix'])){echo "<p class='tur'>Prix: <span class='prix'>" . $voiture['prix'] . "</p></span><br>";}
        if (isset($voiture['annee'])){echo "<p class='tur'>Année de mise en circulation: <span class='annee'>" . $voiture['annee'] . "</p></span><br>";}
        if (isset($voiture['kilometrage'])){echo "<p class='tur'>Kilométrage: <span class='kilometrage'>" . $voiture['kilometrage'] . "</p></span><br>";}
        if (isset($voiture['caracteristiques'])){echo "<p class='tur'>Caractéristiques: <span class='caracteristiques'>" . $voiture['caracteristiques'] . "</p></span><br>";}
        if (isset($voiture['equipements'])){echo "<p class='tur'>Équipements: <span class='equipements'>" . $voiture['equipements'] . "</p></span><br>";}
        


        
        echo "<p class='tur'>référence id : ". $voiture["id"]."</p><br>";
        echo "<br>";

        
        echo "</div>";
       

        require_once "bloc.php";

        echo "<div class='bottom'>";
        echo "<br>";
        echo"<h3>Nous contacter au sujet de cette voiture :</h3>";

        echo'<form action="contactlogic.php" method="post" id="formcont">';

        echo'<div id="ligne1">';
            
        echo'<div id="nomcontacte"><p class="formtur">Votre nom :</p>' ;
        echo'        <input type="text" class="aa" id="nom" name="nom" required></div>';


        echo'<div id="prénomcontacte"><p class="formtur">Votre prénom : </p>';
        echo'        <input type="text" class="aa" id="prenom" name="prenom" required></div>';

        echo'<div id="emailcontacte"><p class="formtur">Votre email : </p>';
        echo'        <input type="mail" class="aa" id="email" name="email" required></div>';


        echo'<div id="phonecontacte"><p class="formtur">Votre numéro de téléphone : </p>';
        echo'        <input type="tel" class="aa" id="phone" name="phone"  required></div>';


        echo'</div>';
        echo'<div id="ligne2">';
        echo'        <div id="titrecontacte"><p class="formtur">Titre du message : </p>';
        echo '<input type="text" class="cc" id="titra" name="titre" value="Contact pour la ' . $voiture["marque"] . ' de référence ' . $voiture["id"] . ' prix :' . $voiture['prix'] . '." required></div>';


        echo'        <div id="commentairecontacte"><p class="formtur">Votre message :</p>';
        echo'<textarea id="messagess" class="aa" name="messages" required></textarea></div>';


          
            
        echo'    <div class="c100" id="submit">';
        echo'        <input type="submit" class="bb" value="Envoyer"></div>';
        echo'</form>';

        echo "</div>";

        echo "</div>";
        echo'</div>';
        echo'<br><hr><br>';

        echo '<script>redirect("formcont","okmess.php");</script>';
        
        
    }
    
    
}
?>


</div>






<!-- ///////////////////////////////////////////ON GERE LE FILTRAGE -->
<script>

    // On ajoute un écouteur d'évènement au formulaire, on met l'évènement 'input' pour que le filtrage se fasse dès qu'on saisit la valeur dans un des champs
document.getElementById('filtrage').addEventListener('input', function(e) {
    // On empeche le rechargement de la page
    e.preventDefault();

    // On stocke dans des variables les différentes valeurs des champs
    let minPrix = document.getElementById('min-prix').value;
    let maxPrix = document.getElementById('max-prix').value;
    let minKilometrage = document.getElementById('min-kilometrage').value;
    let maxKilometrage = document.getElementById('max-kilometrage').value;
    let minAnnee = document.getElementById('min-annee').value;
    let maxAnnee = document.getElementById('max-annee').value;

    // On récupère les éléments html avec la classe voiture
    var voitures = document.getElementsByClassName('voiture');
    // On parcourt toutes les voitures
    for (let i = 0; i < voitures.length; i++) {
        // On stocke dans des variables leur prix, kilometrage et annee, qu'on multiplie pas 1 car ils ne sont pas considéré comme des nombres et ca va poser problème pour les comparer
        let prix = voitures[i].getElementsByClassName('prix')[0].innerText*1;
        let kilometrage = voitures[i].getElementsByClassName('kilometrage')[0].innerText*1;
        let annee = voitures[i].getElementsByClassName('annee')[0].innerText*1;

        // On fait la condition si le prix entré est inférieur ou supérieur au prix de cette voiture etc... en vérifiant préalablement si la valeur min ou et max est renseignée
        if ((minPrix !== '' && prix < minPrix) || 
            (maxPrix !== '' && prix > maxPrix) || 
            (minKilometrage !== '' && kilometrage < minKilometrage) || 
            (maxKilometrage !== '' && kilometrage > maxKilometrage) || 
            (minAnnee !== '' && annee < minAnnee) || 
            (maxAnnee !== '' && annee > maxAnnee)) {

                // Si oui, on n'affiche pas la voitrure
            voitures[i].style.display = 'none';
        } 
        
            // Sinon on l'affiche
        else {
            voitures[i].style.display = 'flex';
        }
    }
});
</script>


</body>
</html>

<footer><?php require_once "horaires.php"?></footer>
