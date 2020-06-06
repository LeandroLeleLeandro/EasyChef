<?php
/*
*     Auteur              :  RUSSOTTI Leandro.
*     Projet              :  EasyChef.
*     Page                :  Formulaire d'édition d'avis.
*     Date début projet   :  25.05.2020.
*/

// récuperé le boutton + le get
$idUser = filter_input(INPUT_GET,"idUser",FILTER_VALIDATE_INT);
$idRate = filter_input(INPUT_GET,"idRate",FILTER_VALIDATE_INT);
$btnConfirmChange = filter_input(INPUT_POST,"btnConfirmChange");
$datasRate = getInformationsOfRate($idRate);
// Lancer le script a l'appuie du bouton
if ($btnConfirmChange) 
{
    $rate = filter_input(INPUT_POST,"rate",FILTER_VALIDATE_INT);
    $comment = filter_input(INPUT_POST,"comment",FILTER_SANITIZE_STRING);
    $idRecipe = FILTER_INPUT(INPUT_GET,"idRecette",FILTER_VALIDATE_INT);

    // Vérifier que la note est bien entre 1 et 5
    if ($rate AND $comment) 
    {
        if ($rate >= 5) 
        {
            $rate = 5;
        }
        if ($rate <= 1) 
        {
            $rate = 1;
        }
        header("Location: rate.php?user=$idUser");
        editRate($idRate,$rate,$comment);
    }
}

?>
<form method="post">
    <ul class="list-group shadow-lg">
        <li class="list-group-item" style="background-color: #453823; color: white;">
            <h4>Modifier l'avis : </h4>
        </li>
        <li class="list-group-item"><h4><span style="color: #382E1C">
            <label for="rate">Votre note :</label>
            <select class="form-control mb-2" id="rate" name="rate" style="color: orange; font-size: 20px;">
                <option value="1" style="color: orange; font-size: 20px;" <?php if ($datasRate{"rating"} == 1) { echo "selected"; } ?>>★</option>
                <option value="2" style="color: orange; font-size: 20px;" <?php if ($datasRate{"rating"} == 2) { echo "selected"; } ?>>★★</option>
                <option value="3" style="color: orange; font-size: 20px;" <?php if ($datasRate{"rating"} == 3) { echo "selected"; } ?>>★★★</option>
                <option value="4" style="color: orange; font-size: 20px;" <?php if ($datasRate{"rating"} == 4) { echo "selected"; } ?>>★★★★</option>
                <option value="5" style="color: orange; font-size: 20px;" <?php if ($datasRate{"rating"} == 5) { echo "selected"; } ?>>★★★★★</option>
            </select>
            <label for="comment">Votre avis :</label>
            <textarea class="form-control mb-3" name="comment" id="comment"><?php if (isset($datasRate{"description"})) { echo $datasRate{"description"}; } ?></textarea>
            <input type="submit" class="form-control btn btn-bouton1" value="Poster l'avis" name="btnConfirmChange">
        </h4></span></li>
    <ul>
</form>