<?php
/*
*     Auteur              :  RUSSOTTI Leandro.
*     Projet              :  fakeTPI.
*     Page                :  Formulaire d'ajout d'animal.
*     Date début projet   :  27.04.2020.
*/

// Variable qui se crée a l'appuie du bouton.
$ok = FILTER_INPUT(INPUT_POST,"frmAjoutAnimal");

// Lance le script a l'appuie du bouton.
if($ok)
{
    // Crée les variables
    $typeAnimal = FILTER_INPUT(INPUT_POST,"typeAnimal",FILTER_SANITIZE_STRING);
    $nameAnimal = FILTER_INPUT(INPUT_POST,"nameAnimal",FILTER_SANITIZE_STRING);
    $dateNaissanceAnimal = FILTER_INPUT(INPUT_POST,"dateNaissanceAnimal");
    $erreur = [];

    // Vérifie si le champ type est bien remplis.
    if (!$typeAnimal)
    {
        $erreur["typeAnimal"] = "Veuillez rentrez un type d'animal valide.";
    }

    // Vérifie si le champ name est bien remplis.
    if (!$nameAnimal)
    {
        $erreur["nameAnimal"] = "Veuillez rentrez un nom d'animal valide.";
    }

    // Vérifie si le champ date n'est pas vide ou faux.
    if (!$dateNaissanceAnimal)
    {
        $erreur["dateNaissanceAnimal"] = "Veuillez rentrez une date de naissance valide.";
    }

    // Continue si il n'y a aucune érreur.
    if (count($erreur) == 0)
    {
        ajouterAnimal($typeAnimal,$nameAnimal,$dateNaissanceAnimal);
        header("Location: index.php");
        exit;
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="shadow-lg card text-dark" style="background-color: #EEEEEE;">
                <div class="card-header text-light p-3 pl-4" style="background-color: #28AD80"><h4>Ajouter un animal</h4></div> 
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="typeAnimal"><h5>Type d'animal :</h5></label>
                                    <?php if (isset($erreur["typeAnimal"])): ?>
                                        <input type="text" class="form-control is-invalid" id="typeAnimal" placeholder="Chien" name="typeAnimal" required>
                                        <div class="invalid-feedback"><?= $erreur["typeAnimal"]; ?></div>
                                    <?php else: ?>
                                        <input type="text" class="form-control" id="typeAnimal" placeholder="Chien" name="typeAnimal" required value="<?php if(isset($typeAnimal)){echo $typeAnimal;}?>">
                                    <?php endif; ?>
                                </div>
                                <div class="col">
                                    <label for="nameAnimal"><h5>Le prénom de votre animal:</h5></label>
                                    <?php if (isset($erreur["nameAnimal"])): ?>
                                        <input type="text" class="form-control is-invalid" id="nameAnimal" placeholder="Banane" name="nameAnimal" required>
                                        <div class="invalid-feedback"><?= $erreur["nameAnimal"]; ?></div>
                                    <?php else: ?>
                                        <input type="text" class="form-control" id="nameAnimal" placeholder="Banane" name="nameAnimal" required value="<?php if(isset($nameAnimal)){echo $nameAnimal;}?>">
                                    <?php endif; ?>
                                </div>
                                <div class="col">
                                    <label for="nameAnimal"><h5>La&nbsp;date&nbsp;de&nbsp;naissance&nbsp;votre&nbsp;animal&nbsp;:</h5></label>
                                    <?php if (isset($erreur["dateNaissanceAnimal"])): ?>
                                        <input type="date" class="form-control is-invalid" id="dateNaissanceAnimal" name="dateNaissanceAnimal" required>
                                        <div class="invalid-feedback"><?= $erreur["dateNaissanceAnimal"]; ?></div>
                                    <?php else: ?>
                                        <input type="date" class="form-control" id="dateNaissanceAnimal" name="dateNaissanceAnimal" required value="<?php if(isset($dateNaissanceAnimal)){echo $dateNaissanceAnimal;}?>">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <hr>
                            <input type="submit" class="form-control btn btn-bouton1" value="Ajouter l'animal" name="frmAjoutAnimal">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
