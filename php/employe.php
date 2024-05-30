<?php
 session_start();
if (!isset($_SESSION['login'])) {
    header('Location: connexion');
    exit();
}

?>
<!DOCTYPE html>


<?php require_once("navbar.php")?>

<?php
require_once("commentlogic.php")?>

<div class="employestyle">

<!-- //////////////////////////////////CONNEXION A LA BDD Coms, ou on utilise la table Commentaires -->

            <!-- ///////////////////////////ON AFFICHE LES INFORMATIONS -->
<h2>Liste des commentaires :</h2>
<br>
            <?php

require_once("pdo.php");

try {
    // On prépare la requète pour obtenir les valeurs rangées triés par id
    $statement = $pdo->prepare("SELECT * FROM Commentaires ORDER BY id");

    // on exécute
    $statement->execute();

    // on récupère les résultats
    $resultcom = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (count($resultcom) > 0) {
        // Afficher les données de chaque ligne
        foreach($resultcom as $row) {
            echo "Nom: " . $row["visitname"]. " - Commentaire: " . $row["commentaire"]. " - Note: " . $row["note"].  " - id : " .$row["id"] ."<br><br><br>";
        }
    } else {
        echo "Pas de commentaire à traiter";
    }

} catch (PDOException $e) { 
    echo $e->getMessage();
}

?>

<br>
<hr>
<br>
<!-- ////////////////////////////ON APPROUVE OU DESAPPROUVE -->

<!-- ///////////////////////FORMULAIRE pour appouver ou non le commentaire-->

<h2>Approuver ou non le commentaire :</h2>
<br>

<form method="post" id ="comments" action="employe">
    <label for=""><p class='fcont'>ID du commentaire : </p></label>
    <input type="number" id="id" name="id" required>

    <label for=""><p class='fcont'>Approuver le commentaire (oui/non) :</p></label>
    <input type="text" id="approuve" name="approuve" required>

    <div class="c100" id="submit">
    <br>
        <input type="submit" class="ddg" name="validcomment" value="Valider">
</form>

<br>
<hr>
<br>

<!-- ////////////////////////PHP pour changer la valeur de approuve 0 non 1 oui -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['validcomment'])) {
    if(isset($_POST["id"])){$id = htmlentities($_POST["id"]);}

    //on utilise trim pour supprimer les espaces
    
    if(isset($_POST["approuve"])){$approuve = trim(htmlentities($_POST["approuve"]));}

    if ($approuve == "oui") {
        // Mettre à jour la colonne 'approuve' à 1
        $sql = "UPDATE Commentaires SET approuve=1 WHERE id=$id";
    } else if ($approuve == "non") {
        // Supprimer la ligne de la table
        $sql = "DELETE FROM Commentaires WHERE id=$id";
    }

    // On exécute la requête
    try {
        if(isset($sql)){$pdo->exec($sql);}

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>

<!-- /////////////////////////////////FORMULAIRE POUR AJOUTER DES VOITURES -->

<h2>Ajouter une voiture à la vente :</h2>
<br>

<form action="employe" id='ajout' method="post" enctype="multipart/form-data">
<p class='fcont'>Marque : </p><input type="text" name="marque"><br>
<p class='fcont'>Prix : </p><input type="number" name="prix" required><br>
<p class='fcont'>Année de mise en circulation : </p><input type="number" name="annee" required><br>
<p class='fcont'>Kilométrage : </p><input type="number" name="kilometrage" required><br>
<p class='fcont'>Caractéristiques : </p><textarea class="areaemploye" name="caracteristiques"></textarea><br>
<p class='fcont'>Équipements et options : </p><textarea class="areaemploye" name="equipements"></textarea><br>
<p class='fcont'>Image principale : </p><input type="file" class="ddg" name="image_principale" required><br>
<p class='fcont'>Galerie d'images : </p><input type="file" class="ddg" name="galerie_images[]" multiple><br>
<br>
    <input type="submit" class="ddg" name="ajout" value="Ajouter voiture">
</form>



<br>
<hr>
<br>
<!-- ////////////////////////////////AJOUTER LES INFOS DES VOITURES DANS UNE BDD -->
<?php



try{
    //on se connecte à mysql


    

    //on crée la table dans laquelle on enregistrera les informations voulus. L'image est VARCHAR car on enregistre seulement le chemin du fichier
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS Voitures (
            id INT AUTO_INCREMENT PRIMARY KEY,
            marque VARCHAR(255) NULL,
            prix VARCHAR(255) NULL,
            annee VARCHAR(255) NULL,
            kilometrage VARCHAR(255) NULL,
            caracteristiques TEXT NULL,
            equipements TEXT NULL,
            image_principale VARCHAR(255) NULL,
            galerie_images TEXT NULL
        )
        ");
        //message d'erreur et arret du script si ca ne fonctionne pas
    }catch (PDOException $e) {
    die($e->getMessage());
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ajout'])) {

    if(isset($_POST['marque'])){$marque = htmlentities($_POST['marque']);}
    if(isset($_POST['prix'])){$prix = htmlentities($_POST['prix']);}
    if(isset($_POST['annee'])){$annee = htmlentities($_POST['annee']);}
    if(isset($_POST['kilometrage'])){$kilometrage = htmlentities($_POST['kilometrage']);}
    if(isset($_POST['caracteristiques'])){$caracteristiques = htmlentities($_POST['caracteristiques']);}
    if (isset($_POST['equipements'])){$equipements = htmlentities($_POST['equipements']);}

    //Si image mise dans le formulaire qui s'appelle image_princiaple
    if (isset($_FILES['image_principale'])) {
        // On récup le nom du fichier et on le stocke dans une variable
        $image_principale = $_FILES['image_principale']['name'];
        // On récupère le type mime du fichier et on le stocke dans $image_type
        $image_type = $_FILES['image_principale']['type'];

        // Vérification du type MIME : si il n'est pas du type jpeg, jpg, png
        if (!in_array($image_type, ['image/jpeg', 'image/jpg', 'image/png'])) {
            echo "<p class='fcont'>L'upload n'a pas fonctionné. Les fichiers doivent être de type jpg, jpeg ou png.</p>";

            exit;
        }

        //Si le type est bon, on définit le chemin de destination pour enregistrer le fichier dans le dossier img/.

        $target = "../img/" . basename($image_principale);

        // On déplace le fichier vers le chemin qu'on vient de créer
        move_uploaded_file($_FILES['image_principale']['tmp_name'], $target);
    }

     // On vérifie si des images ont été téléchargés via le champs galerie image, puis on stocke les valeurs
    if (isset($_FILES['galerie_images'])) {
        $galerie_images = $_FILES['galerie_images'];

        // On parcourt chaque fichier du tableau
        foreach ($galerie_images['name'] as $index => $name) {

            // On récupère leur type respectif
            $image_type = $galerie_images['type'][$index];

            // Vérification du type MIME
            if (!in_array($image_type, ['image/jpeg', 'image/jpg', 'image/png'])) {
                echo "<p class='fcont'>L'upload n'a pas fonctionné. Les fichiers doivent être de type jpg, jpeg ou png.</p>";
                exit;
            }
            
            // On met le chemin de destination des images
            $target = "../img/" . basename($name);
            // On déplace les fichiers vers cet endroit
            move_uploaded_file($galerie_images['tmp_name'][$index], $target);

            // On ajoute les chemins à un tableau
            $imagesNames[] = $target;
        }
    }


    // On implode le tableau qu'on vient de créer, séparé par des virgules, et on stocke le résultat dans la variable
$galerie_images = implode(",", $imagesNames);

    // On prépare la requete pour insérer les valeurs dans la table
    $statement = $pdo->prepare("INSERT INTO Voitures (marque, prix, annee, kilometrage, caracteristiques, equipements, image_principale, galerie_images) VALUES (:marque, :prix, :annee, :kilometrage, :caracteristiques, :equipements, :image_principale, :galerie_images)");
    $statement->bindParam(':marque', $marque);
    $statement->bindParam(':prix', $prix);
    $statement->bindParam(':annee', $annee);
    $statement->bindParam(':kilometrage', $kilometrage);
    $statement->bindParam(':caracteristiques', $caracteristiques);
    $statement->bindParam(':equipements', $equipements);
    $statement->bindParam(':image_principale', $image_principale);
    $statement->bindParam(':galerie_images', $galerie_images);

    // Exécutez la requête
    $statement->execute();


}
    
?>

<!-- ///////////////////////////////Formulaire pour supprimer une voiture par son id -->
<h2>Supprimer une voiture en saisissant son id associé :</h2>
<br>

<form action="" id ="suppr" method="post">
<p class='fcont'>ID de la voiture à supprimer : </p><input type="text" name="id" required><br>
<br>
    <input type="submit" name="supr" class="ddg" value="Supprimer cette voiture">
</form>

<!-- ////////////////////////////////PHP pour supprimer la voiture de la BDD -->

<?php


require_once("pdo.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['supr'])) {
    if (isset($_POST['id'])) {$id = htmlentities($_POST['id']);}

        // On prépare la requète pour supprimer la voiture avec l'id correspondant
        $statement = $pdo->prepare("DELETE FROM Voitures WHERE id = :id");
        // On bind la valeur
        $statement->bindParam(':id', $id);

        // On exécute
        $statement->execute();
    }
?>







</div>
