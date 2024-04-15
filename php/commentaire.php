<!DOCTYPE html>

<!-- //////////////////////Icone d'onglet -->
<link rel="icon" type="image/png" href="../img/logo.png"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../style/style.css">

<!-- //////////////////////Import de l'en tete -->
<header><?php require_once "navbar.php"?></header>



<!-- ///////////////////////////FORMULAIRE CONTACT AVEC NOM COMMENTAIRE ET NOTE -->

<div class="av">

<h2>Donnez-nous votre avis :</h2>


<form method="post" id ="comments" action="commentlogic.php">

                <label for=""><p class="com">Votre nom : </p></label>
                <input type="text" id="nom" name="nom" required><br>



                <label for=""><p class="com">Commentaire :</p></label>
                <input type="text" id="commentaire" name="commentaire" required><br>

                <label for=""><p class="com">Votre note entre 0 et 10 :</p></label>
                <input type="number" min=0 max=10 id="note" name="note" required><br>

          
            
            <div class="c101" id="submit">
                <input type="submit" class="dd" value="Envoyer"></div>
</form>

<br><br>
</div>


<?php

//On vérifie que l'utilisateur a bien écris une note entre 0 et 10

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["note"])) {
        //On fait *1 à htmlentities pour qu'il soit considéré comme un nombre car htmlentities le fait se convertir en un string
        $note = htmlentities($_POST["note"])*1;
        if ($note < 0 ) {
            die("<p class='fcont'>Impossible d'envoyer le formulaire car la valeur indiquée en note est trop petite</p>");
        } 
        if ($note > 10){
            die("<p class='fcont'>Impossible d'envoyer le formulaire car la valeur indiquée en note est trop grande</p>");
        }
    }}?>

<!-- ///////////////////////////////IMPORT DE LA FONCTION POUR REDIRIGER SUR UNE PAGE AUTRE QUE L ACTION DU FORMULAIRE -->

<?php require_once "bloc.php";?>

<!-- ////////////////////////////////UTILISATION DE LA FONCTION -->

<script>redirect('comments','ok.php');</script>











<?php require_once "horaires.php"?>
<?php require_once "footer.php"?>