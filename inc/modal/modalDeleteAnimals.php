<?php
$deleteOk = filter_input(INPUT_POST,"btnDeleteAnimal");

if ($deleteOk) {
    $idAnimalToDelete = filter_input(INPUT_POST,"hdnIdAnimal");
    deleteAnimal($idAnimalToDelete);
    echo("<meta http-equiv='refresh' content='0'>");
}

?>
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-danger">Supprimer un animal</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Voulez vous vraiment supprimer l'animal nommer : <span class="font-weight-bold" id="modalNomAnimal"></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        <form action="" method="post">
            <input type="hidden" name="hdnIdAnimal" id="hiddenDeleteIdAnimal">
            <input type="submit" value="Supprimer" class="btn btn-danger" name="btnDeleteAnimal">
        </form>
      </div>
    </div>
  </div>
</div>
