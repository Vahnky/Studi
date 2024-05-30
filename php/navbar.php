<!DOCTYPE html>
<html lang="fr">
<head>
<title>Garage V.Parrot</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <meta http-equiv="Content-Security-Policy-Report-Only" 
  content="default-src 'self' https://stackpath.bootstrapcdn.com https://code.jquery.com https://cdnjs.cloudflare.com https://ajax.googleapis.com; 
  img-src 'self'">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

  <link rel="icon" type="image/png" href="img/logo.png"/>

  <link rel="stylesheet" href="style/style.css">
</head>
<body>


<!-- ///////////////////////////////////////////On crée notre navbar avec bootstrap -->

<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>




<div class="tout">
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">

  <a class="navbar-brand" href="#"><h1 class="nav">Garage V.Parrot</h1></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">

    <li class="nav-item <?php if ($current_page == 'home') echo 'active'; ?>">
    <a class="nav-link" href=<?php if ($current_page == 'home') {echo '"home"';} else {echo '"home"';}?>>Accueil</a>
</li>

<li class="nav-item <?php if ($current_page == 'connexion') echo 'active'; ?>">
    <a class="nav-link" href=<?php if ($current_page == 'connexion') {echo '"connexion"';} else {echo '"connexion"';}?>>Se connecter</a>
</li>

<li class="nav-item <?php if ($current_page == 'voitures') echo 'active'; ?>">
    <a class="nav-link" href=<?php if ($current_page == 'index.php') {echo '"voitures"';} else {echo '"voitures"';}?>>Voitures en vente</a>
</li>

<li class="nav-item <?php if ($current_page == 'formcontact') echo 'active'; ?>">
    <a class="nav-link" href=<?php if ($current_page == 'index.php') {echo '"formcontact"';} else {echo '"formcontact"';}?>>Nous contacter</a>
</li>

<li class="nav-item <?php if ($current_page == 'commentaire') echo 'active'; ?>">
    <a class="nav-link" href=<?php if ($current_page == 'index.php') {echo '"commentaire"';} else {echo '"commentaire"';}?>>Laisser un avis</a>
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
