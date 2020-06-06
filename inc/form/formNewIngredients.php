<?php
/*
*     Auteur              :  RUSSOTTI Leandro.
*     Projet              :  EasyChef.
*     Page                :  Formulaire d'ajout d'ingrédients.
*     Date début projet   :  25.05.2020.
*/

// Variables GET
$idRecipe = filter_input(INPUT_GET,"idRecipe",FILTER_VALIDATE_INT);
$idUser = filter_input(INPUT_GET,"idUser",FILTER_SANITIZE_STRING);

// Détecter appui du boutton formulaire
$btnAddIngredient = filter_input(INPUT_POST,"btnAddIngredient");

// Lancer le script a l'appuie du bouton
if ($btnAddIngredient) 
{
    // Initialiser + recupérer champs formulaire
    $error = [];
    $unity = "";
    $name = filter_input(INPUT_POST,"newName",FILTER_SANITIZE_STRING);
    $quantity = filter_input(INPUT_POST,"newQuantity",FILTER_VALIDATE_INT);

    // Regarde si le champ unité a été remplis
    if (isset($_POST["newUnity"])) 
    {
        $unity = filter_input(INPUT_POST,"newUnity",FILTER_SANITIZE_STRING);
    }

    // Erreur si le champs name est mauvais
    if (!$name) 
    {
        $error["name"] = "Le champs de nom ne peut être vide.";
    }

    // Erreur si le champs quantité est mauvais
    if (!$quantity) 
    {
        $error["quantity"] = "Le champs de quantité ne peut être vide.";
    }

    // Continue si il n'y a aucune érreur.
    if (count($error) == 0)
    {
        insertNewIngredients($idRecipe,$name,$quantity,$unity);
        echo '<meta http-equiv="refresh" content="0">';
    }
}

?>
<div class="container-fluid mb-5">
    <div class="row">
        <div class="col-lg-10 m-auto">
            <div class="shadow-lg card text-dark" style="background-color: #EEEEEE;">
                <div class="card-header text-light p-3 pl-4" style="background-color: #453823; color: white;"><h4>Ajouter un ingrédient à la recette : <?= getNameOfRecipe($idRecipe); ?><span class="float-right"><button class="btn btn-success" onclick="showFormIngredients()">+</button>&nbsp;<button  class="btn btn-danger" onclick="hideFormIngredients()">-</button></span></h4></div>           
                <div class="card-body p-0 m-0" id="divAddIngredients">
                    <form method="post">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nom ingrédient</th>
                                    <th>Quantité ingrédient</th>
                                    <th>Unité ingrédient<small> (Facultatif)</small></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php if (isset($error["name"])): ?>
                                        <td><input required type="text" class="form-control is-invalid" name="newName"></td>
                                    <?php else: ?>
                                        <td><input required type="text" class="form-control" name="newName" value="<?php if(isset($name)){echo $name;}?>"></td>
                                    <?php endif; ?>

                                    <?php if (isset($error["quantity"])): ?>
                                        <td><input required type="number" class="form-control is-invalid" name="newQuantity"></td>
                                    <?php else: ?>
                                        <td><input required type="number" class="form-control" name="newQuantity" value="<?php if(isset($quantity)){echo $quantity;}?>"></td>
                                    <?php endif; ?>

                                    <td><input type="text" class="form-control" name="newUnity" value="<?php if(isset($unity)){echo $unity;}?>"></td>
                                </tr>
                                <tr>
                                    <td colspan="3"><input type="submit" class="form-control btn btn-bouton1" value="Ajouter ingrédient" name="btnAddIngredient"></td>
                                </tr>
                            </tbody>
                        </table class="table">                         
                    </form>             
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function showFormIngredients()
    {
        document.getElementById("divAddIngredients").style.display = "block";
    }

    function hideFormIngredients()
    {
        document.getElementById("divAddIngredients").style.display = "none";
    }
</script>
                                    