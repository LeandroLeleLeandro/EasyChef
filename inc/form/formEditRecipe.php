<?php
/*
*     Auteur              :  RUSSOTTI Leandro.
*     Projet              :  EasyChef.
*     Page                :  Formulaire d'ajout de recette.
*     Date début projet   :  25.05.2020.
*/

// Variable qui se crée a l'appuie du bouton.
$btnConfirmChange = FILTER_INPUT(INPUT_POST,"btnConfirmChange");
$btnRemoveIngredient = filter_input(INPUT_POST,"btnRemoveIngredient");
$idUser = filter_input(INPUT_GET,"user",FILTER_VALIDATE_INT);
$datasRecipe = getInformationsOfRecipe($idRecipe);
$datasIngredients = getRecetteIngredientsFromId($idRecipe);

// Lance le script a l'appuie du boutton supprimer.
if ($btnRemoveIngredient) 
{
    $idIngredientToRemove = $btnRemoveIngredient;
    removeIngredient($idIngredientToRemove);
    echo '<meta http-equiv="refresh" content="0">';
}

// Lance le script a l'appuie du valider.
if($btnConfirmChange)
{
    // Crée les variables
    $error = [];
    $titleRecipe = filter_input(INPUT_POST,"titleRecipe",FILTER_SANITIZE_STRING);
    $timeRequired = filter_input(INPUT_POST,"timeRequired",FILTER_VALIDATE_INT);
    $description = filter_input(INPUT_POST,"description",FILTER_SANITIZE_STRING);
    $nbIngredient = filter_input(INPUT_POST,"hiddenNbIngredient",FILTER_VALIDATE_INT);
    $havePicture = false;
    
    // Continue si il n'y a aucune érreur.
    if (count($error) == 0)
    {  
        editRecipe($idRecipe,$titleRecipe,$description,$timeRequired);
        
        for ($i=0; $i <$nbIngredient ; $i++) 
        { 
            $unity = "";
            $name = filter_input(INPUT_POST,"nameIngredient".($i+1),FILTER_SANITIZE_STRING);
            $quantity = filter_input(INPUT_POST,"quantityIngredient".($i+1),FILTER_VALIDATE_INT);
            $idIngredientToEdit = filter_input(INPUT_POST,"hidden".($i+1),FILTER_SANITIZE_STRING);

            // Regarde si le champ unité a été remplis
            if (isset($_POST["unityIngredient".($i+1)])) 
            {
                $unity = filter_input(INPUT_POST,"unityIngredient".($i+1),FILTER_SANITIZE_STRING);
            }
            
            editIngredient($idIngredientToEdit,$name,$quantity,$unity);
        }
        echo '<meta http-equiv="refresh" content="0">';
    }
}
?>
<div class="container-fluid mb-5">
    <div class="row">
        <div class="col-lg-10 m-auto">
            <div class="shadow-lg card text-dark" style="background-color: #EEEEEE;">
            <div class="card-header text-light p-3 pl-4" style="background-color: #453823; color: white;"><h4>Modifier la recette : <?= $datasRecipe{"title"}; ?><span class="float-right"><button class="btn btn-success" onclick="showFormEdit()">+</button>&nbsp;<button  class="btn btn-danger" onclick="hideFormEdit()">-</button></span></h4></div>
                <div class="card-body" id="divEditIngredients">
                    <form  enctype="multipart/form-data" method="post">
                    <input type="hidden" name="hiddenNbIngredient" id="hiddenNbIngredient" value="1">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-12 mb-4">
                                    <label><h3 class="text-danger">Attention, si vous modifiez la recette, le status repassera en attente.</h3></label>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label><h5>Titre de la recette :</h5></label>
                                    <?php if (isset($error["titleRecipe"])): ?>
                                        <input type="text" class="form-control is-invalid" name="titleRecipe" required>
                                        <div class="invalid-feedback"><?php if(isset($error["pseudo"])){ echo $error["pseudo"];} ?></div>
                                    <?php else: ?>
                                        <input type="text" class="form-control" name="titleRecipe" required value="<?php if(isset($datasRecipe{"title"})){echo $datasRecipe{"title"}; }?>">
                                    <?php endif; ?>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label><h5>Temps nécessaire : <small>(en minutes)</small></h5></label>
                                    <?php if (isset($error["timeRequired"])): ?>
                                        <input type="number" class="form-control is-invalid" name="timeRequired" required>
                                        <div class="invalid-feedback"><?php if(isset($error["timeRequired"])){ echo $error["timeRequired"];} ?></div>
                                    <?php else: ?>
                                        <input type="number" class="form-control" name="timeRequired" required value="<?php if(isset($datasRecipe{"timeRequired"})){echo $datasRecipe{"timeRequired"};}?>">
                                    <?php endif; ?>
                                </div>
                                <div class="col-lg-12 mb-4">
                                    <label><h5>Marche à suivre :</h5></label>
                                    <?php if (isset($error["description"])): ?>
                                        <textarea class="form-control is-invalid" name="description"></textarea>
                                        <div class="invalid-feedback"><?php if(isset($error["description"])){ echo $error["description"];} ?></div>
                                    <?php else: ?>
                                        <textarea class="form-control" name="description"><?php if(isset($datasRecipe{"description"})){echo $datasRecipe{"description"};}?></textarea>
                                    <?php endif; ?>
                                </div>

                                <?php
                                    $count = 1;
                                    foreach ($datasIngredients as $i) 
                                    {
                                        echo '<div class="container-fluid p-0 m-0 row" id="divIngredients">';
                                        echo    '<div class="col-lg-4 mb-4"><label><h5>Nom ingrédient</h5></label><input required type="text" class="form-control" name="nameIngredient'.$count.'" value="'.$i{"name"}.'"></div>';
                                        echo    '<div class="col-lg-4 mb-4"><label><h5>Quantité ingrédient</h5></label><input required type="number" class="form-control" name="quantityIngredient'.$count.'" value="'.$i{"quantity"}.'"></div>';
                                        echo    '<div class="col-lg-3 mb-4"><label><h5>Unité ingrédient<small> (Facultatif)</small></h5></label><input type="text" class="form-control" name="unityIngredient'.$count.'" value="'.$i{"unity"}.'"></div>';
                                        echo    '<div class="col-lg-1 mb-4"><label><h5>&nbsp;</h5></label><input type="submit" class="form-control btn btn-danger text-danger" value="'.$i{"idIngredient"}.'" value="" name="btnRemoveIngredient"></div>';
                                        echo    '<input type="hidden" value="'.$i{"idIngredient"}.'" name="hidden'.$count.'">';
                                        echo '</div>';
                                        $count++;
                                    }
                                    echo '<input type="hidden" value="'.$count.'" name="hiddenNbIngredient">';
                                    $count = 0;
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">&nbsp;</label>
                            <input type="submit" class="form-control btn btn-bouton1" value="Modifier la recette" name="btnConfirmChange">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function showFormEdit()
    {
        document.getElementById("divEditIngredients").style.display = "block";
    }

    function hideFormEdit()
    {
        document.getElementById("divEditIngredients").style.display = "none";
    }
</script>