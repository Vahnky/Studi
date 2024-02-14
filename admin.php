<?php
//On vérifie : si le $_SESSION[login] n'existe pas, on est redirigé vers connexion.php, il se trouve après la vérification login MDP dans connexion.php,
// ET si le $_SESSION[login] existe mais qu'il est différend de admin, alors on est redirigé sur employe.php
 session_start();
if (!isset($_SESSION['login'])) {
    header('Location: connexion.php');
    exit();
}
else
{
    if($_SESSION['login'] != "admin")
    {
        header('Location: employe.php');
        exit();
    }
}

?>


<!DOCTYPE html>

<link rel="stylesheet" href="style.css">




<!-- //////////////////////////IMPORT DE L EN TETE -->

<header><?php require_once "navbar.php"?></header>

<div class="adminstyle">

<!--/////////////////////////////////////////////FORMULAIRE NOUVEL UTILISATEUR -->
<br>
<h2>Ajouter un utilisateur en renseignant créant son login et son mot de passe :</h2>
<br>

<form action="" method="post">
            
                <br>
                <label for=""><p class='fcont'>Login d'un nouvel employé : </p></label>
                <input type="text" id="login" name="login">


                <br>
                <label for="password"><p class='fcont'>Mot de passe du nouvel employé :</p></label>
                <input type="password" id="password" name="password">

          
            
            <div class="c100" id="submit">
            <br>
                <input type="submit" class="ddg" name="ajout" value="Ajouter nouvel employé">

        </form>


<br>

<hr>
<br>




    <?php

// //////////////////////////////   CREER DE NOUVEAUX UTILISATEURS DANS LA BDD ADMINCO, DANS LA TABLE users AVEC LE FORMULAIRE DANS ADMIN.PHP
// 
try {

    //on crée une nouvelle instance de pdo
    $pdo = new PDO('mysql:host=localhost;dbname=garage', 'root', '');
    //on signifie qu'on utilise la BDD garage
    $pdo->exec("USE garage");
  
    
    //Si erreur
} catch (PDOException $e) {
    die($e->getMessage());
}

    //on utilise cela pour éviter les erreurs de array undefinied que ca m'a fait
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ajout'])) {

    //on stocke les valeurs entrées pour les nouveaux utilisateurs et leur mot de passe dans des variables


    if (isset($_POST['login'])){$login = htmlentities($_POST['login']);}
    if (isset($_POST['password'])){$password = htmlentities($_POST['password']);}

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

?>


<!-- ////////////////////////////////////////////////FORMULAIRE POUR POUVOIR CHANGER DE MOT DE PASSE -->

<h2>Changer le mot de passe en renseignant le login et le nouveau mot de passe :</h2>
<br>
<form action="" method="post" id="supprcompte">

<label for=""><p class='fcont'>Login d'un employé </p></label>
                <input type="text" id="login" name="login"><br>



                <label for="password"><p class='fcont'> Changer mot de passe</p></label>
                <input type="password" id="newpassword" name="newpassword">

          
            
            <div class="c100" id="submit">
                <input type="submit" class="ddg" name="modif" value="Modifier le Mot de Passe">

</form>

<br>
<hr>
<br>

<!-- //////////////////////////////////////////////UPDATE LA TABLE POUR CHANGER LE MOT DE PASSE -->

<?php 

// Si la méthode est POST et que l'on a bien cliqué sur l'input modif
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modif'])) {
    // On récupère le login et le nouveau mot de passe si ils existent
    if(isset($_POST['login'])){$login = htmlentities($_POST['login']);}
    if(isset($_POST['newpassword'])){$newPassword = htmlentities($_POST['newpassword']);}

    // Vérification des conditions du mot de passe : 12 caracs, 1 maj, 1 chiffre, 1 carac spécial
    if (strlen($newPassword) < 12 ||
    !preg_match('/[A-Z]/', $newPassword) ||
    !preg_match('/[a-z]/', $newPassword) ||
    !preg_match('/[0-9]/', $newPassword) ||
    !preg_match('/[^A-Za-z0-9]/', $newPassword)) {

    echo "<p class='fcont'>La modification a échoué. Le mot de passe doit contenir au moins 12 caractères, dont au moins 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial.</p>";}


   else {

    // On prépare la requête pour mettre à jour le mot de passe
    $sql = "UPDATE users SET password = :password WHERE username = :username";

    $statement = $pdo->prepare($sql);

    // On associe les valeurs aux paramètres
    $statement->bindValue(':username', $login);
    $statement->bindValue(':password', password_hash($newPassword, PASSWORD_BCRYPT));

    // On exécute la requête
    $statement->execute();
}}

?>


<!-- //////////////////////////////////////////////FORMULAIRE POUR SUPPRIMER UN UTILISATEUR -->

<br>
<h2>Supprimer un utilisateur en renseignant son login :</h2>
<br>

<form action="" method="post">
    <label for=""><p class='fcont'><p class="fcont">Login de l'utilisateur à supprimer : </p></label>
    <input type="text" id="login" name="login"><br>

    <div class="c100" id="submit">
    <br>
        <input type="submit" class="ddg" name="supprimer" value="Supprimer utilisateur">
</form>

<br>
<hr>
<br>

<!-- ////////////////////////////////////////////PHP POUR LE FORMULAIRE DE SUPPRESSION -->
<?php
try {
    // on crée une nouvelle instance de pdo
    $pdo = new PDO('mysql:host=localhost;dbname=garage', 'root', '');
    $pdo->exec("USE garage");
} catch (PDOException $e) {
    die($e->getMessage());
}

// si la méthode est post et qu'on a bien cliqué sur l'input supprimer
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['supprimer'])) {
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
<h2>Changer les services proposés :</h2>
<br>
<!-- PREMIER SERVICE -->
<form indeax="serv" action="index.php" method="post">
    <label for=""><p class='fcont'>Changer le premier service    :</p></label>
    <input type="text" id="service1" name="service1" /> 



<br><br>

<!-- SECOND SERVICE -->

    <label for=""><p class='fcont'>Changer le second service    :</p></label>
    <input type="text" id="service2" name="service2">
    


<br><br>

<!-- TROISIEME -->

    <label for=""><p class='fcont'>Changer le troisième service  :</p></label>
    <input type="text" id="service3" name="service3">
    
<br><br>

<!-- QUATRIEME -->

    <label for=""><p class='fcont'>Changer le quatrième service :</p></label>
    <input type="text" id="service4" name="service4">
    

<br><br>

<!-- CINQUIEME -->

    <label for=""><p class='fcont'>Changer le cinquième service :</p></label>
    <input type="text" id="service5" name="service5">
    <div class="c100" id="submit">
    <br>
    <input type="submit" class="ddg" name="servi" value="Valider les nouveaux services">
</form>

<!-- /////////////////////////////////////////////////IMPORT DE LA FONCTION PERMETTANT DE RESTER SUR LA PAGE ET NE PAS ALLER SUR L ACTION DU FORMULAIRE -->

<?php require_once('bloc.php'); ?>


<!-- On utilise la fonction redirect de ce qu'on vient d'importer-->
<script>redirect('serv','admin.php');</script>

<br>
<hr>
<br>



        <!-- ////////////////////////////////////////////FORMULAIRE DES HEURES D OUVERTURE qu'on traite sur horaires.php-->
   
<h2>Changer les horaires d'ouverture :</h2>
<br>



        <!-- Formulaire Lundi -->

        <form id="l" action="horaires.php" method="post">
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
<script>redirect('l','admin.php');</script>





<?php require_once('contactlogic.php') ?>




<!-- ////////////////////////////SUPPRIMER UN MESSAGE -->

<!-- ///////////////////////FORMULAIRE pour supprimer un message-->
<h2>Supprimer un message avec son id</h2>
<br>

<form method="post" id ="mes" action="admin.php">
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
$pdo = new PDO('mysql:host=localhost;dbname=garage', 'root', '');

$idmessa="";

// si la method est post et qu'on a cliqué sur l'input supprmess

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['supprmess'])) {

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

$pdo = new PDO('mysql:host=localhost;dbname=garage', 'root', '');

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

