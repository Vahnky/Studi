<!DOCTYPE html>

<?php require_once "navbar.php"?>

<body>
    






<div class="conta">

<div id="contact"><p class= "fcont">Vous pouvez nous contacter au 00 12 34 23 16</p></div>


<!-- //////////////////////FORMULAIRE CONTENANT LE nom, prénom, adresse e-mail, numéro de téléphone et un message -->



<form action="php/contactlogic.php" method="post" id="formcont">



<div id="nomcontact"><p class= "fcont">Votre nom : </p>
                <input class="forcont" type="text" id="nom" name="nom" required></div>


<div id="prénomcontact"><p class= "fcont">Votre prénom : </p>
                <input class="forcont" type="text" id="prenom" name="prenom" required></div>

<div id="emailcontact"><p class= "fcont">Votre email : </p>
                <input class="forcont" type="mail" id="email" name="email" required></div>


<div id="phonecontact"><p class= "fcont">Votre numéro de téléphone :</p>
                <input class="forcont" type="tel" id="phone" name="phone"  required></div>


                <div id="titrecontact"><p class= "fcont">Titre du message : </p>
                <input type="text" class="forcont" id="titremess" name="titre" value="<?php if(isset ($_SESSION['prerempli'])){ echo $_SESSION['prerempli'];}?>" required></div>

                <div id="commentairecontact"><p class= "fcont">Votre message :</p>
        <textarea class="forcont" id="messages" name="messages" required></textarea></div>


          
            
            <div class="c100" id="submitcont">
                <input type="submit" class="dd" value="Envoyer"></div>
</form>

<br><br>
</div>
</body>
<!-- ///////////////////////////////IMPORT DE LA FONCTION POUR REDIRIGER SUR UNE PAGE AUTRE QUE L ACTION DU FORMULAIRE -->

<?php require_once "bloc.php";?>

<!-- ////////////////////////////////UTILISATION DE LA FONCTION -->

<script>redirect('formcont','okmess');</script>

<?php require_once "horaires.php"?>
<?php require_once "footer.php"?>

