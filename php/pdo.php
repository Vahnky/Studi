
<?php


    $dbn="garage";
    $us="root";
    $pss="";

    //on crée une nouvelle instance de pdo
    $pdo = new PDO("mysql:host=localhost;dbname=$dbn", "$us", "$pss");

    $pdo->exec("USE garage");