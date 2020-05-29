<?php
/*
*     Auteur              :  RUSSOTTI Leandro.
*     Projet              :  EasyChef.
*     Page                :  Formulaire de recherche.
*     Date début projet   :  25.05.2020.
*/

// Variable qui se crée a l'appuie du bouton.
$btnResearch = FILTER_INPUT(INPUT_POST,"btnResearch");

// Lance le script a l'appuie du bouton.
if($btnResearch)
{
    // Crée les variables
    $research = FILTER_INPUT(INPUT_POST,"research",FILTER_SANITIZE_STRING);
    $erreur = [];

    // Vérifie si le champ surname est bien remplis.
    if (!$research)
    {
        $erreur["research"] = "Le champs de recherche ne peut pas être vide.";
    }

    // Continue si il n'y a aucune érreur.
    if (count($erreur) == 0)
    {
        $researchOk = $research;
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="shadow-lg card text-dark" style="background-color: #FFF8DC;">
                <div class="card-header text-light p-3 pl-4" style="background-color: #CD853F"><h4>Rechercher une recette</h4></div>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label><h5>Mot clés a rechercher :</h5></label>
                                    <?php if (isset($erreur["research"])): ?>
                                        <input type="text" class="form-control is-invalid" name="research" required>
                                        <div class="invalid-feedback"><?php if(isset($erreur["research"])){ echo $erreur["research"];} ?></div>
                                    <?php else: ?>
                                        <input type="text" class="form-control" name="research" required value="<?php if(isset($research)){echo $research;}?>">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">&nbsp;</label>
                            <input type="submit" class="form-control btn btn-bouton1" value="Rechercher" name="btnResearch">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
