<?php
/*
*     Auteur              :  RUSSOTTI Leandro.
*     Projet              :  EasyChef.
*     Page                :  Formulaire d'inscription.
*     Date début projet   :  25.05.2020.
*/

// Variable qui se crée a l'appuie du bouton.
$btnConnexion = FILTER_INPUT(INPUT_POST,"btnConnexion");

// Lance le script a l'appuie du bouton.
if($btnConnexion)
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
    if (!connectUser($surname,md5($surname,$password)))
    {
        $erreur["login"] = "Pseudo ou mot de passe incorrect.";
    }

    // Continue si il n'y a aucune érreur.
    if (count($erreur) == 0)
    {
        $_SESSION['connect'] = true;
        header("Location: index.php");
        exit;
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="shadow-lg card text-dark" style="background-color: #FFF8DC;">
                <?php if (isset($erreur["inscription"])): ?>
                    <div class="card-header bg-danger"><h5>Erreur dans l'inscription</h5></div>
                <?php else: ?>
                    <div class="card-header text-light p-3 pl-4" style="background-color: #CD853F"><h4>S'inscrire</h4></div>
                <?php endif; ?>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label><h5>Votre pseudo :</h5></label>
                                    <?php if (isset($erreur["surname"])): ?>
                                        <input type="text" class="form-control is-invalid" name="surname" required>
                                        <div class="invalid-feedback"><?php if(isset($erreur["surname"])){ echo $erreur["surname"];} ?></div>
                                    <?php else: ?>
                                        <input type="text" class="form-control" name="surname" required value="<?php if(isset($surname)){echo $surname;}?>">
                                    <?php endif; ?>
                                </div>
                                <div class="col">
                                    <label><h5>Votre email :</h5></label>
                                    <?php if (isset($erreur["email"])): ?>
                                        <input type="text" class="form-control is-invalid" name="email" required>
                                        <div class="invalid-feedback"><?php if(isset($erreur["email"])){ echo $erreur["surname"];} ?></div>
                                    <?php else: ?>
                                        <input type="text" class="form-control" name="email" required value="<?php if(isset($email)){echo $email;}?>">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">&nbsp;</label>
                            <input type="submit" class="form-control btn btn-bouton1" value="Se connecter" name="btnConnexion">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
