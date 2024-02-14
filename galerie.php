<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garage V.Parrot</title>
    <!-- Inclure les fichiers CSS et JS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<?php

// On  crée une connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=garage', 'root', '');

// On récupère la valeur de l’ID de la voiture à partir des paramètres GET de l’URL
$id_voiture = $_GET['id'];

// On prépare la requête SQL pour sélectionner toutes les colonnes de la table “Voitures” où l’ID correspond
$statement = $pdo->prepare("SELECT * FROM Voitures WHERE id = :id");
$statement->execute(['id' => $id_voiture]);

//  On récupère la ligne de résultat de la requête sous forme de tableau associatif
$voiture = $statement->fetch(PDO::FETCH_ASSOC);

// Si la ligne de la voiture a été trouvée
if ($voiture) {
    // On divise la chaîne de caractères contenue dans la colonne galerie_images en un tableau
    $galerie_images = explode(",", $voiture['galerie_images']);

    // Début du carousel Bootstrap
    echo '<div id="monCarousel" class="carousel slide" data-ride="carousel">';
    echo '<div class="carousel-inner">';

    // Parcours de chaque élément du tableau
    foreach ($galerie_images as $index => $image) {
        // Ajout de la classe "active" pour la première image pour que bootstrap fonctionne
        if ($index === 0) {
            $activeClass = 'active';
        } 
        else {
            $activeClass = '';
        }

        // Affichage de chaque image car foreach
        // Pour chaque, une div contenant une balise image avec le chemin de l'image récupérée à partir de la BDD sera créée
        echo '<div class="carousel-item ' . $activeClass . '">';
        echo '<img src="' . $image . '" class="d-block w-100" alt="Image ' . ($index + 1) . '">';
        echo '</div>';
    }

    // Fin du carousel Bootstrap
    echo '</div>';
    echo '</div>';
} else {
    echo "La galerie que vous cherchez n'existe pas";
    exit;
}
?>

<!-- Contrôles précédent/suivant -->
<a class="carousel-control-prev" href="#monCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Précédent</span>
    </a>
    <a class="carousel-control-next" href="#monCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Suivant</span>
    </a>
</div>

</body>
