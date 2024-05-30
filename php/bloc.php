        <!-- ////////////////////////////////////CREATION D UNE FONCTION POUR BLOQUER L OUVERTURE DE L ACTION DES FORMULAIRES -->

<!-- On importe ajax -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- On crée une fonction pour ne pas qu'on aille à la page après action en soumettant le formulaire en gardant les infos -->
<script>
function blocage(formid) {
    $(document).ready(function(){
        $("#" + formid).on('submit', function(e) {
            e.preventDefault(); // On empêche le comportement par défaut du formulaire

            $.ajax({
                url: $(this).attr('action'), // On récupère l'URL de l'attribut 'action'
                type: $(this).attr('method'), // On récupère la méthode de l'attribut 'method'
                data: $(this).serialize(), // On récupère les données du formulaire
                
            });
        });
    });
}
</script>


<!-- /////////////////////////////On crée une autre fonction qui permet de renvoyer à une autre page -->
<script>
function redirect(formid, redirectUrl) {
    $(document).ready(function(){
        $("#" + formid).on('submit', function(e) {
            e.preventDefault(); // On empêche le comportement par défaut du formulaire

            $.ajax({
                url: $(this).attr('action'), // On récupère l'URL de l'attribut 'action'
                type: $(this).attr('method'), // On récupère la méthode de l'attribut 'method'
                data: $(this).serialize(), // On récupère les données du formulaire
                success: function() {
                    window.location.href = redirectUrl; // On redirige vers la nouvelle URL
                },
                error: function() {
                    window.location.href = error.php;
                }
            });
        });
    });
}

</script>









