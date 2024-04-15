

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garage V.Parrot</title>
    <link rel="shortcut icon" href="#" />
    <link rel="stylesheet" href="../style/style.css">
    <link rel="icon" type="image/png" href="img/logo.png"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    


</head>

<header><?php require_once "navbar.php"?></header>

<body>


<?php
require_once("pdo.php");

// max prix

$stmt = $pdo->prepare("SELECT MAX(prix) AS maxprix FROM voitures");
$stmt->execute();


$maxprix = $stmt->fetch(PDO::FETCH_ASSOC)['maxprix'];

// max kilometrage

$stmt = $pdo->prepare("SELECT MAX(kilometrage) AS maxkilometrage FROM voitures");
$stmt->execute();

$maxkilometrage = $stmt->fetch(PDO::FETCH_ASSOC)['maxkilometrage'];

// min année

$stmt = $pdo->prepare("SELECT MIN(annee) AS minannee FROM voitures");
$stmt->execute();

$minannee = $stmt->fetch(PDO::FETCH_ASSOC)['minannee'];


// max année
$stmt = $pdo->prepare("SELECT MAX(annee) AS maxannee FROM voitures");
$stmt->execute();

$maxannee = $stmt->fetch(PDO::FETCH_ASSOC)['maxannee'];

?>


<div class="filtr">
<br>
<h2 class="cach2">Filtres :</h2>
<br>

<button class="accordeon"><p class="formvoit">Filtres</p><img src="../img/logoclick.png" alt="logo click" class="logoclick"> </button>
<div class="panel" style="display: none;">

<!-- //////////////////////////////////////// On crée notre formulaire pour filtrer les voitures proposés-->




<form id="filtrage">



<div class="pair">
<div class="reg">

<div class="formvoit">
    <p>Prix minimum :</p>
    <input type="number" id="min-prix" name="min-prix" min="0" max="<?php echo htmlspecialchars($maxprix); ?>" step="100">
</div>
<div class="formvoit">
    <p>Prix maximum :</p>
    <input type="number" id="max-prix" name="max-prix" min="0" max="<?php echo htmlspecialchars($maxprix); ?>" step="100">
</div>
</div>
<div class="uno">
    <input type="range" id="min-prix-range" name="min-prix-range" min="0" max="<?php echo htmlspecialchars($maxprix); ?>" step="100">
    <input type="range" id="max-prix-range" name="max-prix-range" min="0" max="<?php echo htmlspecialchars($maxprix); ?>" step="100">
</div>

</div>


<div class="pair">
<div class="reg">

    <div class="formvoit">
    <p>Kilométrage minimum :</p>
        <input type="number" id="min-kilometrage" name="min-kilometrage" min="0" max="<?php echo htmlspecialchars($maxkilometrage); ?>" step="1000">
    </div>
    <div class="formvoit">
    <p>Kilométrage maximum :</p>
        <input type="number" id="max-kilometrage" name="max-kilometrage" min="0" max="<?php echo htmlspecialchars($maxkilometrage); ?>" step="1000">
    </div>
    </div>

    <div class="uno">
        <input type="range" id="min-kilometrage-range" name="min-kilometrage-range" min="0" max="<?php echo htmlspecialchars($maxkilometrage); ?>" step="1000">
        <input type="range" id="max-kilometrage-range" name="max-kilometrage-range" min="0" max="<?php echo htmlspecialchars($maxkilometrage); ?>" step="1000">
    </div>
</div>

<div class="pair">
    <div class="reg">
    <div class="formvoit">
    <p>Année minimum :</p>
        <input type="number" id="min-annee" name="min-annee" min="<?php echo htmlspecialchars($minannee); ?>" max="<?php echo htmlspecialchars($maxannee); ?>">
    </div>
    <div class="formvoit">
    <p>Année maximum :</p>
        <input type="number" id="max-annee" name="max-annee" min="<?php echo htmlspecialchars($minannee); ?>" max="<?php echo htmlspecialchars($maxannee); ?>">
    </div>
    </div>
    <div class="uno">
        <input type="range" id="min-annee-range" name="min-annee-range" min="<?php echo htmlspecialchars($minannee); ?>" max="<?php echo htmlspecialchars($maxannee); ?>">
        <input type="range" id="max-annee-range" name="max-annee-range" min="<?php echo htmlspecialchars($minannee); ?>" max="<?php echo htmlspecialchars($maxannee); ?>">
    </div>
</div>


</form>

</div>
</div>





<!-- Mettre tout à 0 pour le min ou au max -->


<script>
        window.addEventListener('load', function() {

            // Récupération
            const minPrixRange = document.getElementById('min-prix-range');
            const maxPrixRange = document.getElementById('max-prix-range');
            const minPrixInput = document.getElementById('min-prix');
            const maxPrixInput = document.getElementById('max-prix');
            const minKilometrageRange = document.getElementById('min-kilometrage-range');
            const maxKilometrageRange = document.getElementById('max-kilometrage-range');
            const minKilometrageInput = document.getElementById('min-kilometrage');
            const maxKilometrageInput = document.getElementById('max-kilometrage');
            const minAnneeRange = document.getElementById('min-annee-range');
            const maxAnneeRange = document.getElementById('max-annee-range');
            const minAnneeInput = document.getElementById('min-annee');
            const maxAnneeInput = document.getElementById('max-annee');

            // Initialisation
            minPrixRange.value = minPrixRange.min;
            maxPrixRange.value = maxPrixRange.max;
            minPrixInput.value = minPrixRange.min;
            maxPrixInput.value = maxPrixRange.max;
            minKilometrageRange.value = minKilometrageRange.min;
            maxKilometrageRange.value = maxKilometrageRange.max;
            minKilometrageInput.value = minKilometrageRange.min;
            maxKilometrageInput.value = maxKilometrageRange.max;
            minAnneeRange.value = minAnneeRange.min;
            maxAnneeRange.value = maxAnneeRange.max;
            minAnneeInput.value = minAnneeRange.min;
            maxAnneeInput.value = maxAnneeRange.max;


            maxPrixRange.addEventListener('input', function() {

                if (parseInt(minPrixRange.value) >= parseInt(maxPrixRange.value)) {
                    minPrixRange.value = maxPrixRange.value;
                    minPrixInput.value = maxPrixInput.value;
                }
            });


            minPrixRange.addEventListener('input', function() {

                if (parseInt(minPrixRange.value) >= parseInt(maxPrixRange.value)) {
                    maxPrixRange.value = minPrixRange.value;
                    maxPrixInput.value = minPrixInput.value;

                }
            });
            


            maxKilometrageRange.addEventListener('input', function() {

                if (parseInt(minKilometrageRange.value) >= parseInt(maxKilometrageRange.value)) {
                    minKilometrageRange.value = maxKilometrageRange.value;
                    minKilometrageInput.value = maxKilometrageInput.value;
                }

            });


            minKilometrageRange.addEventListener('input', function() {

                if (parseInt(minKilometrageRange.value) >= parseInt(maxKilometrageRange.value)) {
                    maxKilometrageRange.value = minKilometrageRange.value;
                    maxKilometrageInput.value = minKilometrageInput.value;
                }
            });



                maxAnneeRange.addEventListener('input', function() {

                if (parseInt(minAnneeRange.value) >= parseInt(maxAnneeRange.value)) {
                    minAnneeRange.value = maxAnneeRange.value;
                    minAnneeInput.value = maxAnneeInput.value;
                }
            });


            minAnneeRange.addEventListener('input', function() {

                if (parseInt(minAnneeRange.value) >= parseInt(maxAnneeRange.value)) {
                    maxAnneeRange.value = minAnneeRange.value;
                    maxAnneeInput.value = minAnneeInput.value;
                }
            });


            syncValues(minPrixInput, minPrixRange);
            syncValues(maxPrixInput, maxPrixRange);

            syncValues(minKilometrageInput, minKilometrageRange);
            syncValues(maxKilometrageInput, maxKilometrageRange);

            syncValues(minAnneeInput, minAnneeRange);
            syncValues(maxAnneeInput, maxAnneeRange);

        });



// //////////////////////////////////////////On fait en sorte que l'input de type number = input de type range pour que les valeurs se suivent

// ////////////////On crée une fonction syncValues qui prend en argument les futurs input de type number et range
    const syncValues = (input1, input2) => {
        // /////////////////////   l'attribut oninput est l'évènement d'une modification, qui va faire en sorte que les valeurs des 2 inputs soient = quand une se modifie l'autre aussi
        input1.oninput = () => input2.value = input1.value;
        input2.oninput = () => input1.value = input2.value;
    };


</script>








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






<!-- ////////////////////////////////////////////////////On affiche les voitures en se connectant à la base de données cars, table Voitures créés dans employe.php -->

<div class="vtur">
<br>
<h2>Nos voitures :</h2>
<br>
<div class="containCars">
<?php

// /////////////////////////////////////////On se co à la BDD et on vérifie si la table Voitures existe et on stocke ses infos dans une variable
require_once("pdo.php");
require_once ("bloc.php");

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
        echo'<div class="voiturees">';
        echo'<div class="card" style="width: 18rem;">';
        echo '<img src="../img/' . $voiture["image_principale"] . '" class="card-img-top" alt="Photo de la voiture">';
        echo'<div class="card-body">';
        echo '<h5 class="card-title">' . $voiture["marque"] . '</h5>';
        echo '<p class="card-text">Prix : <span class=\'prix\'>' . $voiture['prix'] . '</span>,<br>
        Année :  <span class=\'annee\'>' . $voiture['annee'] . '</span>,<br>
        Kilométrage : <span class=\'kilometrage\'>' . $voiture['kilometrage'] . '</span>,<br>
        ID : ' . $voiture['id'] .
        '</p>';
  
        echo '<div id="details"> <a href="details.php?id=' . $voiture['id'] . '" class="btn btn-primary">Détails</a></div>';
        echo'</div>';
        echo'</div>';
        echo'</div>';
        
    }
    
    
}
?>


</div>
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

    // On récupère les éléments html avec l'id
    let voiturees = document.getElementsByClassName('voiturees');
    // On parcourt toutes les voitures
    for (let i = 0; i < voiturees.length; i++) {
        // On stocke dans des variables leur prix, kilometrage et annee, qu'on multiplie pas 1 car ils ne sont pas considéré comme des nombres et ca va poser problème pour les comparer
        let prix = voiturees[i].getElementsByClassName('prix')[0].innerText*1;
        let kilometrage = voiturees[i].getElementsByClassName('kilometrage')[0].innerText*1;
        let annee = voiturees[i].getElementsByClassName('annee')[0].innerText*1;

        // On fait la condition si le prix entré est inférieur ou supérieur au prix de cette voiture etc... en vérifiant préalablement si la valeur min ou et max est renseignée
        if ((minPrix !== '' && prix < minPrix) || 
            (maxPrix !== '' && prix > maxPrix) || 
            (minKilometrage !== '' && kilometrage < minKilometrage) || 
            (maxKilometrage !== '' && kilometrage > maxKilometrage) || 
            (minAnnee !== '' && annee < minAnnee) || 
            (maxAnnee !== '' && annee > maxAnnee)) {

                // Si oui, on n'affiche pas la voitrure
            voiturees[i].style.display = 'none';
        } 
        
            // Sinon on l'affiche
        else {
            voiturees[i].style.display = 'flex';
        }
    }
});
</script>


</body>
</html>

<?php require_once "horaires.php"?>
<?php require_once "footer.php"?>
