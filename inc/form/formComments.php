<?php
/*
*     Auteur              :  RUSSOTTI Leandro.
*     Projet              :  EasyChef.
*     Page                :  Formulaire d'avis.
*     Date début projet   :  25.05.2020.
*/

$pseudo = $_SESSION["pseudo"];

$btnSendComment = filter_input(INPUT_POST,"btnSendComment");

if ($btnSendComment) 
{
    $rate = filter_input(INPUT_POST,"rate",FILTER_VALIDATE_INT);
    $comment = filter_input(INPUT_POST,"comment",FILTER_SANITIZE_STRING);
    $idRecipe = FILTER_INPUT(INPUT_GET,"idRecette",FILTER_VALIDATE_INT);

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
        insertRate(getIdUserFromPseudo($pseudo),$idRecipe,$rate,$comment);
    }
}
?>
<form method="post">
    <ul class="list-group shadow-lg">
        <li class="list-group-item" style="background-color: #BAA378; color: white;">
            <h4>Poster un avis en tant que <span style="color: #2C2416"><?= ucfirst($pseudo); ?></span> : </h4>
        </li>
        <li class="list-group-item"><h4><span style="color: #382E1C">
            <label for="rate">Votre note :</label>
            <select class="form-control mb-2" id="rate" name="rate" style="color: orange; font-size: 20px;">
                <option value="1" style="color: orange; font-size: 20px;">★</option>
                <option value="2" style="color: orange; font-size: 20px;">★★</option>
                <option value="3" style="color: orange; font-size: 20px;">★★★</option>
                <option value="4" style="color: orange; font-size: 20px;">★★★★</option>
                <option value="5" style="color: orange; font-size: 20px;" selected>★★★★★</option>
            </select>
            <label for="comment">Votre avis :</label>
            <textarea class="form-control mb-3" name="comment" id="comment"></textarea>
            <input type="submit" class="form-control btn btn-bouton1" value="Poster l'avis" name="btnSendComment">
        </h4></span></li>
    <ul>
</form>