<?php
session_start();
ob_start(); // Active la mise en tampon de sortie

// /////////////////////////////////////////////////// VERIFICATION SI LE USER/PASS ENTRE EST BON ET REDIRECTION SI ADMIN OU AUTRE
//On crée notre BDD, Table, et utilisateur admin
//
$non="";
try {
    //on se connecte à mysql
    require_once("pdo.php");
    
    //on crée la table users dans laquelle il sera renseigné les username et MDP
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL
        )
    ");
    //en cas de problème
} catch (PDOException $e) {
    die($e->getMessage());
}
    //on compte le nombre de ligne que contient users
$statement = $pdo->query('SELECT COUNT(*) FROM users');
//On récupère et stocke le résultat de la requète précédente
$result = $statement->fetch();

    //si la ligne 0 vaut 0, on crée l'admin qui aura comme password Admin@123
if ($result[0] == 0) {

    //on crée des variables
    $log = "admin";
    $password = "admin";

    //on stocke dans la $sql notre volonté d'insérer dans la table users les valeurs des variables qu'on vient de créer
    $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
    //on fait une requête préparée, pour ce qu'on veut faire au dessus, afin de pouvoir crypter en dessous le MDP
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':username', $log);
    $statement->bindValue(':password', password_hash($password, PASSWORD_BCRYPT));
;
    //on execute ce qu'on voulait faire
    $statement->execute();
}


// ///////////////////////////////////////////////////////////VERIFICATION LOGIN ET MOT DE PASSE ET BLOCAGE 
//


//On met ca pour éviter qu'il m'affiche une erreur avec $_POST['login'] et $_POST['pass']
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //On stocke dans des variables ce qu'à tapper quelqu'un dans le formulaire en protégeant contre l'(injection avec htmlentities)
        $login = htmlentities($_POST['login']);
        $pass = htmlentities($_POST['pass']);
    
//On prépare notre requète qui va chercher dans la table un utilisateur par son username
        $statement = $pdo->prepare('SELECT * FROM users WHERE username = :username');

        // On lie la valeur de :username à la variable $login. C’est-à-dire que :username dans la requête SQL sera remplacé par la valeur de $login
        $statement->bindValue(':username', $login);
    
        //On teste et exécute la requête SQL. 
        if ($statement->execute()) {
            //On récupère le résultat de la requête SQL sous forme de tableau associatif 
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            //Si $user est faux, c'est à dire qu'aucun username n'est trouvé dans la table
            if ($user === false) {
                $non=1;
            } else {
                //On vérifie si le mot de passe entré par l’utilisateur correspond au mot de passe haché stocké
                if (password_verify($pass, $user['password'])) {
                    //on enregistre dans la session le login
                    $_SESSION['login'] = $login;
                    //Si le login est admin, on va à la page admin.php
                    if ($login == "admin"){
                    echo 'Bienvenue ' . $login;
header('Location: admin');}
                    //Sinon on va à la page employe.php
                    else{ echo 'Bienvenue ' . $login;
header('Location: employe'); }
                    exit();
                } 
                //Sinon, le mot de passe ne correspond pas 
                else {
                    $non=1;
                }
            }
        } 
        //ca n'a pas marché pour une raison inconnue
        else {
            $non=1;
        }

}
ob_end_flush(); // Envoie le contenu du tampon de sortie et désactive la mise en tampon de sortie
?>
<!DOCTYPE html>
<!-- /////////////////////////////////////////////On lie cet html au fichier css, affiche le logo dans l'onglet et importe l'en tete -->
<head>
<title>Garage V.Parrot</title>

<link rel="icon" type="image/png" href="../img/logo.png"/>
<meta charset="UTF-8">
</head>

<html>
    
<header><?php require_once "navbar.php"?></header>

<div class="co">
<br>
<h1>Formulaire de connexion pour l'administrateur et les employés</h1>
      <br>  

<!--/////////////////////////////////// FORMULAIRE POUR SE CONNECTER EN TANT QUE EMPLOYE OU ADMINISTRATEUR -->

        <form method="post" action="connexion">
            

                <label for="nom d'utilisateur"><p class="index">Nom d'utilisateur : </p></label>
                <input type="text" id="login" name="login" required><br>



                <label for="password"><p class="index">Mot de passe : </p></label>
                <input type="password" id="pass" name="pass" required><br>

          
            
                <input type="submit" class="dd" value="Envoyer">

        </form>

        <?php

if ($non==1){
    echo "<p class='fcont'>Le login ou le password ne sont pas exacts</p>";
}

?>

<br><br>
</div>


<?php require_once "horaires.php"?>
<?php require_once "footer.php"?>
    </body>
</html>
