<?php
/*
*     Auteur              :  RUSSOTTI Leandro.
*     Projet              :  EasyChef.
*     Page                :  Formulaire d'inscription.
*     Date début projet   :  25.05.2020.
*/

// Variable qui se crée a l'appuie du bouton.
$btnInscription = FILTER_INPUT(INPUT_POST,"btnInscription");

// Lance le script a l'appuie du bouton.
if($btnInscription)
{
    // Crée les variables
    $email = FILTER_INPUT(INPUT_POST,"email",FILTER_VALIDATE_EMAIL);
    $pseudo = FILTER_INPUT(INPUT_POST,"pseudo",FILTER_SANITIZE_STRING);
    $password = FILTER_INPUT(INPUT_POST,"password",FILTER_SANITIZE_STRING);
    $password2 = FILTER_INPUT(INPUT_POST,"password2",FILTER_SANITIZE_STRING);
    $erreur = [];

    // Vérifie si le champ surname est bien remplis.
    if (!$pseudo)
    {
        $erreur["pseudo"] = "Le pseudonyme entré est incomplet";
    }
    // Vérifie si un pseudonyme existe déjà
    if (pseudonymeAlreadyExist($pseudo))
    {
        $erreur["pseudo"] = "Ce pseudonyme est déjà pris";
    }
    // Vérifie si le champ password n'est pas vide ou faux.
    if (!$password)
    {
        $erreur["password"] = "Le mot de passe est incomplet";
    } 
    // Vérifie si les mots de passes sont indentiques
    if ($password != $password2) 
    {
        $erreur["password"] = "Les mots de passes ne correspondent pas";
    }
    // Vérifie si le champ email est bien remplis.
    if (!$email)
    {
        $erreur["email"] = "L'email est incomplète ou fausse";
    }
    // Continue si il n'y a aucune érreur.
    if (count($erreur) == 0)
    {
        insertNewUser(sha1($pseudo.$password),$email,$pseudo);
        $_SESSION["pseudo"] = $pseudo;
        $_SESSION["connect"] = true;
        header("Location: index.php");
        exit;
    }
    else
    {
        $erreur["inscription"] = "Erreur dans l'inscription";
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="shadow-lg card text-dark" style="background-color: #FFF8DC;">
                <?php if (isset($erreur["inscription"])): ?>
                    <div class="card-header text-light p-3 pl-4" style="background-color: #A52A2A"><h4><?php if(isset($erreur["inscription"])){ echo $erreur["inscription"];} ?></h4></div>
                <?php else: ?>
                    <div class="card-header text-light p-3 pl-4" style="background-color: #CD853F"><h4>S'inscrire</h4></div>
                <?php endif; ?>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label class="mb-0 pb-0"><h5>Votre pseudo :</h5></label>
                                    <?php if (isset($erreur["pseudo"])): ?>
                                        <input type="text" class="form-control is-invalid" name="pseudo" required>
                                        <div class="invalid-feedback"><?php if(isset($erreur["pseudo"])){ echo $erreur["pseudo"];} ?></div>
                                    <?php else: ?>
                                        <input type="text" class="form-control" name="pseudo" required value="<?php if(isset($pseudo)){echo $pseudo;}?>">
                                    <?php endif; ?>
                                </div>   
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label class="mb-0 pb-0"><h5>Votre email :</h5></label>
                                    <?php if (isset($erreur["email"])): ?>
                                        <input type="email" class="form-control is-invalid" name="email" required>
                                        <div class="invalid-feedback"><?php if(isset($erreur["email"])){ echo $erreur["email"];} ?></div>
                                    <?php else: ?>
                                        <input type="email" class="form-control" name="email" required value="<?php if(isset($email)){echo $email;}?>">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label class="mb-0 pb-0"><h5>Mot de passe :</h5></label>
                                    <?php if (isset($erreur["password"])): ?>
                                        <input type="password" class="form-control is-invalid" name="password" required>
                                        <div class="invalid-feedback"><?php if(isset($erreur["password"])){ echo $erreur["password"];} ?></div>
                                    <?php else: ?>
                                        <input type="password" class="form-control" name="password" required value="">
                                    <?php endif; ?>
                                </div>
                                <div class="col">
                                    <label class="mb-0 pb-0"><h5>Confirmation mot de passe :</h5></label>
                                    <?php if (isset($erreur["password"])): ?>
                                        <input type="password" class="form-control is-invalid" name="password2" required>
                                        <div class="invalid-feedback"></div>
                                    <?php else: ?>
                                        <input type="password" class="form-control" name="password2" required value="">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">&nbsp;</label>
                            <input type="submit" class="form-control btn btn-bouton1" value="S'inscrire" name="btnInscription">
                        </div>
                    </form>
                </div>    
            </div>
        </div>
    </div>
</div>
