<!DOCTYPE html>
<html lang="fr">
<head>
<title>Garage V.Parrot</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="stylenav.css">
  <link rel="icon" type="image/png" href="img/logo.png"/>
</head>
<body>


<div class="logo">
    <img class="logo-image" src="img/logo.png" alt="Logo Garage"/>
</div>

<!-- ///////////////////////////////////////////On crée notre navbar avec bootstrap -->

<div class="tout">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

  <a class="navbar-brand" href="#">Garage V.Parrot</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">

    <!-- ////////////////////////////////Basename renvoi le nom du fichier sans le chemin le précédent (pas utile pour l'instant) -->
    <!-- ////////////////////////////////$_SERVER['PHP_SELF'] renvoi le chemin du fichier à la fin de l'url -->
    <!-- ////////////////////////////////Du coup, si l' url == notre fichier on ajoute active pour le visuel dans la navbar -->

    <li class="nav-item <?php if(basename($_SERVER['PHP_SELF']) == 'index.php') echo 'active'; else echo ''; ?>">
    <a class="nav-link" href="index.php"><p class="navi">Accueil</p></a>
    </li>
    <li class="nav-item <?php if(basename($_SERVER['PHP_SELF']) == 'connexion.php') echo 'active'; else echo ''; ?>">
    <a class="nav-link" href="connexion.php"><p class="navi">Se connecter</p></a>
    </li>
    <li class="nav-item <?php if(basename($_SERVER['PHP_SELF']) == 'voitures.php') echo 'active'; else echo ''; ?>">
    <a class="nav-link" href="voitures.php"><p class="navi">Voitures en vente</p></a>
    </li>
    <li class="nav-item <?php if(basename($_SERVER['PHP_SELF']) == 'formcontact.php') echo 'active'; else echo ''; ?>">
    <a class="nav-link" href="formcontact.php"><p class="navi">Nous contacter</p></a>
    </li>
    <li class="nav-item <?php if(basename($_SERVER['PHP_SELF']) == 'commentaire.php') echo 'active'; else echo ''; ?>">
    <a class="nav-link" href="commentaire.php"><p class="navi">Laisser un avis</p></a>
    </li>
    </ul>
  </div>
</nav>
</div>



<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
