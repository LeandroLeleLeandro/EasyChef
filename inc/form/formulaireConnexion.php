<?php
/*
*     Auteur              :  RUSSOTTI Leandro.
*     Projet              :  EasyChef.
*     Page                :  Formulaire de connexion.
*     Date début projet   :  25.05.2020.
*/

// Variable qui se crée a l'appuie du bouton.
$btnConnexion = FILTER_INPUT(INPUT_POST,"btnConnexion");

// Lance le script a l'appuie du bouton.
if($btnConnexion)
{
    // Crée les variables
    $pseudo = FILTER_INPUT(INPUT_POST,"pseudo",FILTER_SANITIZE_STRING);
    $password = FILTER_INPUT(INPUT_POST,"password",FILTER_SANITIZE_STRING);
    $erreur = [];

    // Vérifie si le champ surname est bien remplis.
    if (!$pseudo)
    {
        $erreur["pseudo"] = "Le champ pseudo ne peut être vide.";
    }

    // Vérifie si le champ password n'est pas vide ou faux.
    if (!$password)
    {
        $erreur["password"] = "Le champ mot de passe ne peut être vide.";
    } 

    // Vérifie si les informations de connexion sont bonnes.
    if (!connectUser($pseudo,sha1($pseudo.$password)))
    {
        $erreur["login"] = "Pseudo ou mot de passe incorrect.";
    }

    // Continue si il n'y a aucune érreur.
    if (count($erreur) == 0)
    {
        $_SESSION["pseudo"] = $pseudo;
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
                    <div class="card-header text-light p-3 pl-4" style="background-color: #A52A2A"><h4><?php if(isset($erreur["login"])){ echo $erreur["login"];} ?></h4></div>
                <?php else: ?>
                    <div class="card-header text-light p-3 pl-4" style="background-color: #453823; color: white;"><h4>Se connecter</h4></div>
                <?php endif; ?>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label><h5>Votre pseudo :</h5></label>
                                    <?php if (isset($erreur["pseudo"])): ?>
                                        <input type="text" class="form-control is-invalid" name="pseudo" required>
                                        <div class="invalid-feedback"><?php if(isset($erreur["pseudo"])){ echo $erreur["pseudo"];} ?></div>
                                    <?php else: ?>
                                        <input type="text" class="form-control" name="pseudo" required value="<?php if(isset($pseudo)){echo $pseudo;}?>">
                                    <?php endif; ?>
                                </div>
                                <div class="col">
                                    <label><h5>Votre mot de passe :</h5></label>
                                    <?php if (isset($erreur["password"])): ?>
                                        <input type="password" class="form-control is-invalid" name="password" required>
                                        <div class="invalid-feedback"><?php if(isset($erreur["password"])){ echo $erreur["password"];} ?></div>
                                    <?php else: ?>
                                        <input type="password" class="form-control" name="password" required value="">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">&nbsp;</label>
                            <input type="submit" class="form-control btn btn-bouton1" value="Se connecter" name="btnConnexion">
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                <p class="text-left"><h6>Pas de compte ?  s'incrire <a href="inscription.php"> ici </a></h6></p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
