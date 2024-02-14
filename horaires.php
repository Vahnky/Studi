<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

</head>
<body>
<!--////////////////////////////////  PDO HEURES D OUVERTURE QUI VIENNENT DES FORMULAIRES D ADMIN.PHP -->
    <?php
try{
    //on se connecte à mysql
    $pdo = new PDO('mysql:host=localhost;', 'root', '');

    //on crée une base de donnée si elle n'est pas déja existante
    $pdo->exec("CREATE DATABASE IF NOT EXISTS garage");
    //on lui dit qu'on veut utiliser cette base de données
    $pdo->exec("USE garage");
    //on crée la table dans laquelle on enregistrera les heures voulues
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS heures (
            id INT AUTO_INCREMENT PRIMARY KEY,
            lundi VARCHAR(255) NULL,
            mardi VARCHAR(255) NULL,
            mercredi VARCHAR(255) NULL,
            jeudi VARCHAR(255) NULL,
            vendredi VARCHAR(255) NULL,
            samedi VARCHAR(255) NULL,
            dimanche VARCHAR(255) NULL


        )
        ");
        //message d'erreur et arret du script si ca ne fonctionne pas
    }catch (PDOException $e) {
    die($e->getMessage());
}

//On met ca car il peut y avoir des problème de $_POST[jour] undefined
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //On stocke dans des variables le texte entré par admin sur sa page
    if(isset($_POST["lundi"])){
    $lundi = $_POST["lundi"];}

    if(isset($_POST["mardi"])){
    $mardi = $_POST["mardi"];}

    if(isset($_POST["mercredi"])){
    $mercredi = $_POST["mercredi"];}

    if(isset($_POST["jeudi"])){
    $jeudi = $_POST["jeudi"];}

    if(isset($_POST["vendredi"])){
    $vendredi = $_POST["vendredi"];}

    if(isset($_POST["samedi"])){
    $samedi = $_POST["samedi"];}

    if(isset($_POST["dimanche"])){
    $dimanche = $_POST["dimanche"];}





    try {
        
        //On prépare la requète qui est d'insérer les valeurs dans les colonnes
        $statement = $pdo->prepare("INSERT INTO heures( lundi, mardi, mercredi, jeudi, vendredi, samedi, dimanche) VALUES (:lundi, :mardi, :mercredi, :jeudi, :vendredi, :samedi, :dimanche);");

        $statement->bindParam(':lundi', $lundi);
        $statement->bindParam(':mardi', $mardi);
        $statement->bindParam(':mercredi', $mercredi);
        $statement->bindParam(':jeudi', $jeudi);
        $statement->bindParam(':vendredi', $vendredi);
        $statement->bindParam(':samedi', $samedi);
        $statement->bindParam(':dimanche', $dimanche);

        //On exécute
        $statement->execute();
        //en cas d'erreur
    } catch(PDOException $e) {
    $e->getMessage();
    }
}

//Maintenant que les données des heures sont stockées dans la table

try {
    // On prépare la requète pour obtenir les valeurs rangées triés par id
    $statement = $pdo->prepare("SELECT * FROM heures ORDER BY id DESC");
    // on exécute
    $statement->execute();

    // on récupère les résultats
    $resultat = $statement->fetch(PDO::FETCH_ASSOC);

    // On les stockent dans des variables qu'on va pourvoir utiliser dans des div
    if ($resultat) {

        if(isset($resultat['lundi'])){
    $lundi = $resultat['lundi'];}

    if(isset($resultat['mardi'])){
    $mardi = $resultat['mardi'];}

    if(isset($resultat['mercredi'])){
    $mercredi = $resultat['mercredi'];}

    if(isset($resultat['jeudi'])){
    $jeudi = $resultat['jeudi'];}

    if(isset($resultat['vendredi'])){
    $vendredi = $resultat['vendredi'];}

    if(isset($resultat['samedi'])){
    $samedi = $resultat['samedi'];}

    if(isset($resultat['dimanche'])){
    $dimanche = $resultat['dimanche'];}
    //Si erreur
   
} 

}
catch(PDOException $e) {
    echo $e->getMessage();
}


?>
<div class="hor">
<!-- ///////////////////////////////////////////////ON ECRIT SUR LES PAGES LES DIFFERNTES HEURES -->
<br>
<h2>Horaires d'ouverture</h2>

<div>
    
<p class="index">Lundi : <?php if(isset ($lundi)){echo $lundi;} ?></p>
</div>
<div>
<p class="index">Mardi: <?php if(isset ($mardi)){ echo $mardi;} ?></p>
</div>
<div>
<p class="index">Mercredi : <?php if(isset ($mercredi)){ echo $mercredi;} ?></p>
</div>
<div>
<p class="index">Jeudi: <?php if(isset ($jeudi)){ echo $jeudi;} ?></p>
</div>
<div>
<p class="index">   Vendredi : <?php if(isset ($vendredi)){ echo $vendredi;} ?></p>
</div>
<div>
<p class="index">Samedi: <?php if(isset ($samedi)){ echo $samedi;} ?></p>
</div>
<div>
<p class="index">Dimanche : <?php if(isset ($dimanche)){ echo $dimanche;} ?></p>
</div>

<br><br>
</div>
</body>
</html>