<?php
/*
*     Auteur              :  RUSSOTTI Leandro.
*     Projet              :  EasyChef.
*     Page                :  Formulaire d'ajout de recette.
*     Date début projet   :  25.05.2020.
*/

// Variable qui se crée a l'appuie du bouton.
$btnNewRecipe = FILTER_INPUT(INPUT_POST,"btnNewRecipe");

// Lance le script a l'appuie du bouton.
if($btnNewRecipe)
{
    // Crée les variables
    $error = [];
   

    // Continue si il n'y a aucune érreur.
    if (count($error) == 0)
    {  
        exit;
    }
    else
    {
        $error["recipe"] = "Erreur dans le formulaire";
    }
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-10 m-auto">
            <div class="shadow-lg card text-dark" style="background-color: #EEEEEE;">
                <?php if (isset($erreur["recipe"])): ?>
                    <div class="card-header text-light p-3 pl-4" style="background-color: #A52A2A"><h4><?php if(isset($erreur["recipe"])){ echo $erreur["recipe"];} ?></h4></div>
                <?php else: ?>
                    <div class="card-header text-light p-3 pl-4" style="background-color: #453823; color: white;"><h4>Ajouter une recette</h4></div>
                <?php endif; ?>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-6 mb-4">
                                    <label><h5>Titre de la recette :</h5></label>
                                    <?php if (isset($erreur["titleRecipe"])): ?>
                                        <input type="text" class="form-control is-invalid" name="titleRecipe" required>
                                        <div class="invalid-feedback"><?php if(isset($erreur["pseudo"])){ echo $erreur["pseudo"];} ?></div>
                                    <?php else: ?>
                                        <input type="text" class="form-control" name="titleRecipe" required value="<?php if(isset($titleRecipe)){echo $titleRecipe;}?>">
                                    <?php endif; ?>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label><h5>Temps nécessaire : <small>(en minutes)</small></h5></label>
                                    <?php if (isset($erreur["timeRequired"])): ?>
                                        <input type="number" class="form-control is-invalid" name="timeRequired" required>
                                        <div class="invalid-feedback"><?php if(isset($erreur["timeRequired"])){ echo $erreur["timeRequired"];} ?></div>
                                    <?php else: ?>
                                        <input type="number" class="form-control" name="timeRequired" required value="<?php if(isset($timeRequired)){echo $timeRequired;}?>">
                                    <?php endif; ?>
                                </div>
                                <div class="col-lg-12 mb-4">
                                    <label><h5>Marche à suivre :</h5></label>
                                    <?php if (isset($erreur["description"])): ?>
                                        <textarea class="form-control is-invalid" name="description"></textarea>
                                        <div class="invalid-feedback"><?php if(isset($erreur["description"])){ echo $erreur["description"];} ?></div>
                                    <?php else: ?>
                                        <textarea class="form-control" name="description"></textarea>
                                    <?php endif; ?>
                                </div>
                                <div class="col-lg-12 mb-4">
                                    <label><h5>Photo de la recette : <small>(facultatif)</small></h5></label>
                                    <?php if (isset($erreur["description"])): ?>
                                        
                                    <?php else: ?>
                                        <input type="file" class="form-control-file" name="picture">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">&nbsp;</label>
                            <input type="submit" class="form-control btn btn-bouton1" value="Poster la recette" name="btnNewRecipe">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>