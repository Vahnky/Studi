<?php
 session_start();
if (!isset($_SESSION['login'])) {
    header('Location: connexion');
    exit();
}
else
{
    if($_SESSION['login'] != "admin")
    {
        header('Location: employe');
        exit();
    }
}

?>
<!DOCTYPE html>



<header><?php require_once "navbar.php"?></header>

<div class="adminstyle">



<h2 id="AMS">Sélectionnez une action sur un utilisateur</h2>

<form action="admin" id="clientForm" method="post">

    <label>Choisissez :</label>
    <input type="radio" id="creer" name="action" value="creer">
    <label for="creer">Créer</label>

    <input type="radio" id="modifier" name="action" value="modifier">
    <label for="modifier">Modifier</label>

    <input type="radio" id="supprimer" name="action" value="supprimer">
    <label for="supprimer">Supprimer</label>

    <br>
            
                <label for=""><p class='fcont'>Login : </p></label>
                <input type="text" id="login" name="login">


                <br>
                <div id="password">
                <label for="password" class="password"><p class='fcont'>Mot de passe :</p></label>
                <input type="password" class="password"  name="password"></div>

          
            
            <br>
                <input type="submit" class="ddg" id="boutton" name="ajout" value="Sélectionnez une action">
</form>



<hr>
<br>




<script>
    const creerRadio = document.getElementById("creer");
    const modifierRadio = document.getElementById("modifier");
    const supprimerRadio = document.getElementById("supprimer");
    const h2Element = document.getElementById("AMS");

    creerRadio.addEventListener("change", () => {
        h2Element.textContent = "Créer un utilisateur en renseignant son login et son mot de passe :";
        document.getElementById("password").style.display="inline";
        document.getElementById("boutton").value = "Créer un nouvel utilisateur";
    });

    modifierRadio.addEventListener("change", () => {
        h2Element.textContent = "Modifier un utilisateur en renseignant son login et en tappant le nouveau mot de passe";
        document.getElementById("password").style.display="inline";
        document.getElementById("boutton").value = "Modifier cet utilisateur";
    });

    supprimerRadio.addEventListener("change", () => {
        h2Element.textContent = "Supprimer un utilisateur en renseignant son login";
        document.getElementById("password").style.display="none";
        document.getElementById("boutton").value = "Supprimer cet utilisateur";
    });
</script>






    <?php

// //////////////////////////////   CREER DE NOUVEAUX UTILISATEURS DANS LA BDD ADMINCO, DANS LA TABLE users AVEC LE FORMULAIRE DANS ADMIN.PHP
// 
try {

    require_once("pdo.php");
  
    
    //Si erreur
} catch (PDOException $e) {
    die($e->getMessage());
}

if(isset($_POST["action"])){$action = $_POST["action"];}


    //on utilise cela pour éviter les erreurs de array undefinied que ca m'a fait
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ajout']) && isset($_POST["action"]) && $action === "creer") {

    if (isset($_POST['login'])){$login = htmlentities($_POST['login']);}
if (isset($_POST['password'])){$password = htmlentities($_POST['password']);}

    //on stocke les valeurs entrées pour les nouveaux utilisateurs et leur mot de passe dans des variables




     // Vérification des conditions du mot de passe : 12 caracs, 1 maj, 1 chiffre, 1 carac spécial, merci grafikart
     if (strlen($password) < 12 ||
     !preg_match('/[A-Z]/', $password) ||
     !preg_match('/[a-z]/', $password) ||
     !preg_match('/[0-9]/', $password) ||
     !preg_match('/[^A-Za-z0-9]/', $password)) {
     echo "La création a échoué. Le mot de passe doit contenir au moins 12 caractères, dont au moins 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial.";}

 
    else {//on prépare la requete d'ajouter les nouveaux utilisateurs et leur mot de passe dans la base de données

    $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";

    $statement = $pdo->prepare($sql);

    //On signifie que dans la colonne username, on aura le login
    $statement->bindValue(':username', $login);
    //on signifie que dans la colonne password, on aura le mot de passe haché
    $statement->bindValue(':password', password_hash($password, PASSWORD_BCRYPT));

    //On exécute la requete précédemment préparée
    $statement->execute();
}}





//////////////////////////////////////////////UPDATE LA TABLE POUR CHANGER LE MOT DE PASSE -->



// Si la méthode est POST et que l'on a bien cliqué sur l'input modif
else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ajout']) && isset($_POST["action"]) && $action === "modifier") {
    // On récupère le login et le nouveau mot de passe si ils existent
    if(isset($_POST['login'])){$login = htmlentities($_POST['login']);}
    if(isset($_POST['password'])){$password = htmlentities($_POST['password']);}

    // Vérification des conditions du mot de passe : 12 caracs, 1 maj, 1 chiffre, 1 carac spécial
    if (strlen($password) < 12 ||
    !preg_match('/[A-Z]/', $password) ||
    !preg_match('/[a-z]/', $password) ||
    !preg_match('/[0-9]/', $password) ||
    !preg_match('/[^A-Za-z0-9]/', $password)) {

    echo "<p class='fcont'>La modification a échoué. Le mot de passe doit contenir au moins 12 caractères, dont au moins 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial.</p>";}


   else {

    // On prépare la requête pour mettre à jour le mot de passe
    $sql = "UPDATE users SET password = :password WHERE username = :username";

    $statement = $pdo->prepare($sql);

    // On associe les valeurs aux paramètres
    $statement->bindValue(':username', $login);
    $statement->bindValue(':password', password_hash($password, PASSWORD_BCRYPT));

    // On exécute la requête
    $statement->execute();
}}






//////////////////////////////////////////PHP POUR SUPPRESSION -->



// si la méthode est post et qu'on a bien cliqué sur l'input supprimer
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ajout']) && isset($_POST["action"]) && $action === "supprimer") {
    require_once("pdo.php");
    // on stocke le champs de login dans une variable si il est set
    if (isset($_POST['login'])){$login = htmlentities($_POST['login']);}

    // on écrit la requete qui est delete de la table users le username correspondant
    $sql = "DELETE FROM users WHERE username = :username";
    // on prépare, on bind la valeur et on exécute
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':username', $login);
    $statement->execute();
}
?>



<!--/////////////////////////////////////////////////////////////////////// FORMULAIRES POUR SERVICE qu'on traite sur index.php -->


<h2 id="AMS2">Sélectionnez une action sur un service</h2>

<form action="home" id="clientForm" method="post" enctype="multipart/form-data">

    <label>Choisissez :</label>
    <input type="radio" id="creerserv" name="action" value="creer">
    <label for="creer">Créer</label>

    <input type="radio" id="modifierserv" name="action" value="modifier">
    <label for="modifier">Modifier</label>

    <input type="radio" id="supprimerserv" name="action" value="supprimer">
    <label for="supprimer">Supprimer</label>

    <br>
            
                <label for="service"><p class='fcont'>Titre du service :</p></label>
                <input type="text" id="service" name="titreservice" /> <br>


                <div id="descrservice">
                <label for="descrservice"><p class='fcont'>Descriptif du service :</p></label>
                <input type="text" name="descrservice"></div><br>
                
                <div id="image">
                <label for="image"><p class='fcont'>Image du service :</p></label>
                <input type="file" name="imageserv" > </div><br>

          
            
            <br>
                <input type="submit" id="boutton2" class="ddg" name="servi" value="Sélectionnez une action">
</form>



<hr>
<br>




<script>
    const creerRadio2 = document.getElementById("creerserv");
    const modifierRadio2 = document.getElementById("modifierserv");
    const supprimerRadio2 = document.getElementById("supprimerserv");
    const h2Element2 = document.getElementById("AMS2");

    creerRadio2.addEventListener("change", () => {
        h2Element2.textContent = "Créer un nouveau service :";
        document.getElementById("descrservice").style.display="inline";
        document.getElementById("image").style.display="inline";
        document.getElementById("boutton2").value = "Créer un nouveau service";
    });

    modifierRadio2.addEventListener("change", () => {
        h2Element2.textContent = "Modifier un service en renseignant son titre";
        document.getElementById("descrservice").style.display="inline";
        document.getElementById("image").style.display="inline";
        document.getElementById("boutton2").value = "Modifier ce service";
    });

    supprimerRadio2.addEventListener("change", () => {
        h2Element2.textContent = "Supprimer un service en renseignant son titre";
        document.getElementById("descrservice").style.display="none";
        document.getElementById("image").style.display="none";
        document.getElementById("boutton2").value = "Supprimer ce service";
    });
</script>



<!-- /////////////////////////////////////////////////IMPORT DE LA FONCTION PERMETTANT DE RESTER SUR LA PAGE ET NE PAS ALLER SUR L ACTION DU FORMULAIRE -->

<?php require_once('bloc.php'); ?>


<!-- On utilise la fonction redirect de ce qu'on vient d'importer-->
<script>redirect('serv','admin');</script>

<br>
<hr>
<br>



        <!-- ////////////////////////////////////////////FORMULAIRE DES HEURES D OUVERTURE qu'on traite sur horaires.php-->
   
<h2>Changer les horaires d'ouverture :</h2>
<br>



        <!-- Formulaire Lundi -->

        <form id="l" action="php/horaires.php" method="post">
        <label for=""><p class='fcont'>Heures d'ouverture du Lundi : </p></label>
        <input type="text" id="lundi" name="lundi">
        <br><br>

        <!-- Formulaire Mardi -->

        <label for=""><p class='fcont'>Heures d'ouverture du mardi : </p></label>
        <input type="text" id="mardi" name="mardi">
        <br><br>

        <!-- Formulaire mercredi-->

        <label for=""><p class='fcont'>Heures d'ouverture du mercredi : </p></label>
        <input type="text" id="mercredi" name="mercredi">
        <br><br>

        <!-- Formulaire jeudi-->

        <label for=""><p class='fcont'>Heures d'ouverture du jeudi : </p></label>
        <input type="text" id="jeudi" name="jeudi">
        
        <br><br>
        <!-- Formulaire vendredi -->

        <label for=""><p class='fcont'>Heures d'ouverture du vendredi : </p></label>
        <input type="text" id="vendredi" name="vendredi">
        
        <br><br>
        <!-- Formulaire samedi -->


        <label for=""><p class='fcont'>Heures d'ouverture du samedi : </p></label>
        <input type="text" id="samedi" name="samedi">
        <br><br>
        <!-- Formulaire dimanche -->


        <label for=""><p class='fcont'>Heures d'ouverture du dimanche : </p></label>
        <input type="text" id="dimanche" name="dimanche">
        <br><br>
        <div class="c100" id="submit">
        <input type="submit" class="ddg" name="changeheure" value="Valider les nouveaux horaires">
        </form>

        <br>
<hr>
<br>

<!-- On utilise la fonction redirect ajax pour bloquer l'ouverture de la nouvelle page par l'action du formulaire et qu'on aille sur admin.php = reste sur la meme page -->
<script>redirect('l','admin');</script>





<?php require_once('contactlogic.php') ?>



<!-- ////////////////////////////SUPPRIMER UN MESSAGE -->

<!-- ///////////////////////FORMULAIRE pour supprimer un message-->
<h2>Supprimer un message avec son id</h2>
<br>

<form method="post" id ="mes" action="admin">
    <div id="idmessagesuppr"><p class='fcont'>ID du message : </p>
    <input type="number" id="idmessa" name="idmessa" required></div><br>

    

    <div class="c100" id="suppr">
        <input type="submit" class="ddg" name="supprmess" value="Supprimer ce message">
</form>

<br>
<hr>
<br>

<?php

// ///////////////////////////////On crée une nouvelle instance de pdo avec le dbname garage


$idmessa="";

// si la method est post et qu'on a cliqué sur l'input supprmess

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['supprmess'])) {

    require_once("pdo.php");

    // si le champ d'id est renseigné, alors on le stocke dans une variable
    if(isset($_POST["idmessa"])){$idmessa = $_POST["idmessa"];}

    // on delete dans la table Messagess le mess qui a l'id correspondant
    $sql = "DELETE FROM Messagess WHERE idmess= :idmessa";

    // On prépare la requête
    $stmt = $pdo->prepare($sql);

    // On lie la valeur
    $stmt->bindValue(':idmessa', $idmessa);

    // On exécute la requête
    try {
        $stmt->execute();

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>



<!-- /////////////////////////////////////////////////////AFFICHAGE DES MESSAGES RECUS -->
<h2>Liste des messages :</h2>
<br>
<!-- //////////////////////////////////CONNEXION A LA BDD Mess, ou on utilise la table Messages -->

            <!-- ///////////////////////////ON AFFICHE LES INFORMATIONS -->

            <?php



try {
    // On prépare la requète pour obtenir les valeurs rangées triés par id
    $statement = $pdo->prepare("SELECT * FROM Messagess ORDER BY idmess");

    // on exécute
    $statement->execute();

    // on récupère les résultats
    $resultmes = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (count($resultmes) > 0) {
        // On affiche les données de chaque ligne
        foreach($resultmes as $row) {
            echo "<p class='fcont'>Nom: " . $row["nom"]. " - Message: " . $row["messages"]. " - email: " . $row["email"]. " - téléphone : " . $row['phone'] . "id : " .$row["idmess"] ."</p><br><br>";
        }
    } 
    // on écrit pas de message si il n'y en a pas
    else {
        echo "<p class='fcont'>Pas de Message à traiter</p>";
        echo "<br>";
    }

} catch (PDOException $e) { 
    echo $e->getMessage();
}

?>

<br>
<hr>
<br>



</div>
    
    </body>

