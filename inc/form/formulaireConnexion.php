<?php
/*
*     Auteur              :  RUSSOTTI Leandro.
*     Projet              :  fakeTPI.
*     Page                :  Formulaire de connexion.
*     Date début projet   :  27.04.2020.
*/

// Variable qui se crée a l'appuie du bouton.
$ok = FILTER_INPUT(INPUT_POST,"formLogin");

// Lance le script a l'appuie du bouton.
if($ok)
{
    // Crée les variables
    $surname = FILTER_INPUT(INPUT_POST,"surname",FILTER_SANITIZE_STRING);
    $password = FILTER_INPUT(INPUT_POST,"password",FILTER_SANITIZE_STRING);
    $erreur = [];

    // Vérifie si le champ surname est bien remplis.
    if (!$surname)
    {
        $erreur["surname"] = ".";
    }

    // Vérifie si le champ password n'est pas vide ou faux.
    if (!$password)
    {
        $erreur["password"] = ".";
    }

    // Vérifie si les informations de connexion sont bonnes.
    if (!connectUser($surname,hashPassword($surname,$password)))
    {
        $erreur["login"] = "Pseudo ou mot de passe incorrect.";
    }

    // Continue si il n'y a aucune érreur.
    if (count($erreur) == 0)
    {
        $_SESSION["surname"] = $surname;
        $_SESSION['connect'] = true;
        header("Location: index.php");
        exit;
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="shadow-lg card text-dark" style="background-color: #EEEEEE;">
                <?php if (isset($erreur["login"])): ?>
                    <div class="card-header bg-danger"><h5>Pseudo ou mot de passe incorrect</h5></div>
                <?php else: ?>
                    <div class="card-header text-light p-3 pl-4" style="background-color: #35393C"><h4>Se connecter</h4></div>
                <?php endif; ?>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="nomStagiaire"><h5>Votre pseudo :</h5></label>
                                    <?php if (isset($erreur["surname"])): ?>
                                        <input type="text" class="form-control is-invalid" id="surname" placeholder="Erreur dans votre pseudo" name="surname" required>
                                        <div class="invalid-feedback">Veuillez rentrez une pseudo valide.</div>
                                    <?php else: ?>
                                        <input type="text" class="form-control" id="surname" placeholder="Email" name="surname" required value="<?php if(isset($surname)){echo $surname;}?>">
                                    <?php endif; ?>
                                </div>
                                <div class="col">
                                    <label for="password"><h5>Votre mot de passe :</h5></label>
                                    <?php if (isset($erreur["password"])): ?>
                                        <input type="password" class="form-control is-invalid" id="password" placeholder="******" name="password" required>
                                        <div class="invalid-feedback">Veuillez rentrez un mot de passe valide.</div>
                                    <?php else: ?>
                                        <input type="password" class="form-control" id="prenomStagiaire" placeholder="******" name="password" required value="<?php if(isset($password)){echo $password;}?>">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">&nbsp;</label>
                            <input type="submit" class="form-control btn btn-bouton1" value="Se connecter" name="formLogin">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
