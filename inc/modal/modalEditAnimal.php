<?php

// Variable qui se crée a l'appuie du bouton.
$editOk = filter_input(INPUT_POST,"btnEditAnimal");

// Lance le script a l'appuie du bouton.
if($editOk)
{
    // Crée les variables
    $nouveauTypeAnimal = FILTER_INPUT(INPUT_POST,"nouveauTypeAnimal",FILTER_SANITIZE_STRING);
    $nouveauPrenomAnimal = FILTER_INPUT(INPUT_POST,"nouveauPrenomAnimal",FILTER_SANITIZE_STRING);
    $nouvelleDateAnimal = FILTER_INPUT(INPUT_POST,"nouvelleDateAnimal");
    $idAnimalToEdit = filter_input(INPUT_POST,"hdnIdAnimal");

    if ($nouveauPrenomAnimal && $nouveauTypeAnimal && $nouvelleDateAnimal) {
        editAnimal($idAnimalToEdit,$nouveauPrenomAnimal,$nouvelleDateAnimal,$nouveauTypeAnimal);
        echo("<meta http-equiv='refresh' content='0'>");
    }
}

?>
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary">Modifier l'animal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="nouveauTypeAnimal" class="mb-0 mt-0 text-dark"><h5>Type d'animal :</h5></label>
                                <input type="text" class="form-control text-primary" id="nouveauTypeAnimal" name="nouveauTypeAnimal" required value="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="nouveauPrenomAnimal" class="mb-0 mt-4 text-dark"><h5>Prénom animal :</h5></label>
                                <input type="text" class="form-control text-primary" id="nouveauPrenomAnimal" name="nouveauPrenomAnimal" required value="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="nouvelleDateAnimal" class="mb-0 mt-4 text-dark"><h5>Date naissance animal :</h5></label>
                                <input type="date" class="form-control text-primary" id="nouvelleDateAnimal" name="nouvelleDateAnimal" required value="2018-07-22">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button> 
                    <input type="hidden" name="hdnIdAnimal" id="hiddenEditIdAnimal">
                    <input type="submit" value="Modifier" class="btn btn-success" name="btnEditAnimal">
                </div>
            </form>
        </div>
    </div>
</div>