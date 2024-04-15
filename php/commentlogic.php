
<!-- ////////////////////////////////////// PDO POUR STOCKER LE NOM, COMMENTAIRE, LA NOTE DANS LA BDD Coms et la table Commentaires, infos venues du form commentaire.php-->




<?php



try{

    require_once("pdo.php");

// on crée la table Commentaires
$pdo->exec("
        CREATE TABLE IF NOT EXISTS Commentaires (
            id INT AUTO_INCREMENT PRIMARY KEY,
            visitname VARCHAR(255) NULL,
            commentaire LONGTEXT NULL,
            note VARCHAR(255) NULL,
            approuve BOOL NULL

        )
        ");
        //message d'erreur et arret du script si ca ne fonctionne pas
    }catch (PDOException $e) {
    die($e->getMessage());
}


// //////////////////////On évite différentes erreurs
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $visitname = $commentaire = $note = $approuve = "";

    // ///////////////////////On stocke les informations protégés avec htmlentities dans des variables
    
    if (isset($_POST["nom"]) && isset($_POST["commentaire"]) && isset($_POST["note"])) {
        $visitname = htmlentities($_POST["nom"]);
        $commentaire = htmlentities($_POST["commentaire"]);
        $note = htmlentities($_POST["note"])*1;
        $approuve = "";

        try {
            //On prépare la requète qui est d'insérer les valeurs dans les colonnes
            $statement = $pdo->prepare("INSERT INTO Commentaires (visitname, commentaire, note, approuve) VALUES (:visitname, :commentaire, :note, :approuve);");
            // On bind les valeurs
            $statement->bindParam(':visitname', $visitname);
            $statement->bindParam(':commentaire', $commentaire);
            $statement->bindParam(':note', $note);
            $statement->bindParam(':approuve', $approuve);
            //On exécute
            $statement->execute();
            //en cas d'erreur
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
}
    
?>




