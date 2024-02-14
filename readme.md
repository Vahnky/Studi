Explication du lancement en localhost :

installer xamp,
aller dans le dossier ou on a installé xampp,
créer dans htdocs un dossier ECF,
copier tous les dossiers et fichiers contenu dans "code source local" dans le dossier créé ECF,
lancer xampp en vérifiant que Apache et MySQL soient bien lancés, en vert,
aller sur un navigateur et tapper localhost/ECF/index.php,

(
il y a une redondance du code pour que peu importe sur quelle page on commence et ce qu'on fasse, la BDD soit bien crée et la table nécessaire aussi, pour qu'il n'y ait pas d'erreurs,
et pour faire en sorte de suivre ce qui est demandé dans l'énoncé : ne pas utiliser phpmyadmin.
C'est pourquoi le php utilisé ici comme $pdo->exec("CREATE DATABASE IF NOT EXISTS xxxx") ... pour le déploiement du site sera différend : La BDD sera créée en amont avec un user et un mot de passe.
)

///////////////////////////////


pour se connecter au compte administrateur, on clique sur l'onglet se connecter, ou alors on va sur localhost/ECF/connexion.php


///////////////////////////


l'utilisateur :  admin   et son mot de passe  :  admin      sont créés par le php, dans le code local, il suffit de les tapper et cliquer sur le bouton de validation


////////////////////////////

pour pouvoir ajouter les images des voitures à vendre : image principale et galerie d'image ; fonctionnalité disponible dans le compte employe, il faut mettre les images souhaitées dans un dossier qu'on nommera img, ce dossier est déja créé dans le dossier code source local

//////////////////////////


on arrive sur la page admin de laquelle on peut créer des comptes employés qui ont d'autres fonctionnalités,

on peut aussi retrouver sur cette page les fonctionnalités d'admin demandées

il y a une vérification sur la sécurité du mot de passe au niveau de la taille et des caractères devant le constituer

pour se connecter à un compte employé, il faut saisir l'identifiant et le mot de passe sur la page connexion.php




