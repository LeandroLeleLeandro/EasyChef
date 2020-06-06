<?php
/*
*     Auteur              :  RUSSOTTI Leandro.
*     Projet              :  EasyChef.
*     Page                :  Formulaire d'effacage d'avis.
*     Date début projet   :  25.05.2020.
*/

// Variable qui se crée a l'appuie du bouton.
$btnRemoveRate = FILTER_INPUT(INPUT_POST,"btnRemoveRate");
$btnCancel = filter_input(INPUT_POST,"btnCancel");
$idUserGet = FILTER_INPUT(INPUT_GET,"idUser",FILTER_VALIDATE_INT);
$idRate = filter_input(INPUT_GET,"idRate",FILTER_VALIDATE_INT);

// Lance le script a l'appuie du bouton.
if($btnRemoveRate)
{
    removeRate($idRate);
    header("Location: rate.php?user=".$idUserGet);
    exit;
}

// Lance le script a l'appuie du bouton.
if($btnCancel)
{
   header("Location: rate.php?user=".$idUserGet);
   exit;
}

?>
<div class="container-fluid mb-5">
    <div class="row">
        <div class="col-lg-10 m-auto">
            <div class="shadow-lg card text-dark" style="background-color: #EEEEEE;">
                <div class="card-header text-light p-3 pl-4" style="background-color: #453823; color: white;"><h4>Voulez vous vraiment supprimer votre avis</h4></div>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <div class="row mt-2">
                                <div class="col-lg-6">
                                    <input type="submit" value="Confirmer" class="form-control btn btn-success" name="btnRemoveRate">           
                                </div>
                                <div class="col-lg-6">
                                    <input type="submit" value="Annuler" class="form-control btn btn-danger" name="btnCancel">           
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>