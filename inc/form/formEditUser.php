<?php
/*
*     Auteur              :  RUSSOTTI Leandro.
*     Projet              :  EasyChef.
*     Page                :  Formulaire d'édition des données utilisateurs.
*     Date début projet   :  25.05.2020.
*/

// Variable qui se crée a l'appuie du bouton.
$btnConfirmChange = FILTER_INPUT(INPUT_POST,"btnConfirmChange");

// Id de l'user récuperé en get.
$idUser = filter_input(INPUT_GET,"idUser",FILTER_VALIDATE_INT);

// Données de l'utilisateur
$datasUser = getInformationsOfUser($idUser);
$pseudo = $datasUser{"pseudo"};
$email = $datasUser{"email"};
$success = false;

// Lance le script a l'appuie du bouton.
if($btnConfirmChange)
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
        $success = true;
        editUser($idUser,$pseudo,$email,sha1($pseudo.$password));
        $_SESSION["pseudo"] = $pseudo;
        $_SESSION["connect"] = true;
    }
    else
    {
        $erreur["edition"] = "Erreur dans la modification";
    }
}
?>

<?php if($success): ?>
    <div class="container-fluid mb-5">
        <div class="row">
            <div class="col-lg-10 m-auto">
                <div class="shadow-lg card text-dark" style="background-color: #EEEEEE;">             
                    <div class="alert alert-success" role="alert">
                        <h3 class="alert-heading">Succès !</h3>
                        <hr> 
                        <p>Vos données de connexion ont bien été modifiée !</p>
                    </div>                            
                </div>        
            </div>
        </div>
    </div>
<?php endif; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-10 m-auto">
            <div class="shadow-lg card text-dark" style="background-color: #EEEEEE;">
                <?php if (isset($erreur["edition"])): ?>
                    <div class="card-header text-light p-3 pl-4" style="background-color: #A52A2A"><h4><?php if(isset($erreur["edition"])){ echo $erreur["edition"];} ?></h4></div>
                <?php else: ?>
                    <div class="card-header text-light p-3 pl-4" style="background-color: #453823; color: white;"><h4>Modifier vos donnés de connexion</h4></div>
                <?php endif; ?>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-6 mb-4">
                                    <label class="mb-0 pb-0"><h5>Nouveau pseudo :</h5></label>
                                    <?php if (isset($erreur["pseudo"])): ?>
                                        <input type="text" class="form-control is-invalid" name="pseudo" required>
                                        <div class="invalid-feedback"><?php if(isset($erreur["pseudo"])){ echo $erreur["pseudo"];} ?></div>
                                    <?php else: ?>
                                        <input type="text" class="form-control" name="pseudo" required value="<?php if(isset($pseudo)){echo $pseudo;}?>">
                                    <?php endif; ?>
                                </div>   

                                <div class="col-lg-6 mb-4">
                                    <label class="mb-0 pb-0"><h5>Nouveau votre email :</h5></label>
                                    <?php if (isset($erreur["email"])): ?>
                                        <input type="email" class="form-control is-invalid" name="email" required>
                                        <div class="invalid-feedback"><?php if(isset($erreur["email"])){ echo $erreur["email"];} ?></div>
                                    <?php else: ?>
                                        <input type="email" class="form-control" name="email" required value="<?php if(isset($email)){echo $email;}?>">
                                    <?php endif; ?>
                                </div>

                                <div class="col-lg-6 mb-4">
                                    <label class="mb-0 pb-0"><h5>Nouveau mot de passe :</h5></label>
                                    <?php if (isset($erreur["password"])): ?>
                                        <input type="password" class="form-control is-invalid" name="password" required>
                                        <div class="invalid-feedback"><?php if(isset($erreur["password"])){ echo $erreur["password"];} ?></div>
                                    <?php else: ?>
                                        <input type="password" class="form-control" name="password" required value="">
                                    <?php endif; ?>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label class="mb-0 pb-0"><h5>Confirmation nouveau mot de passe :</h5></label>
                                    <?php if (isset($erreur["password"])): ?>
                                        <input type="password" class="form-control is-invalid" name="password2" required>
                                        <div class="invalid-feedback"></div>
                                    <?php else: ?>
                                        <input type="password" class="form-control" name="password2" required value="">
                                    <?php endif; ?>
                                </div>
                                <div class="col-lg-12 mt-4">
                                    <input type="submit" class="form-control btn btn-bouton1" value="Confirmer les changements" name="btnConfirmChange">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>    
            </div>
        </div>
    </div>
</div>
<script>
function myFunction() 
{
    var x = document.createElement("INPUT");
    x.setAttribute("type", "text");
    x.setAttribute("value", "You Just added a text field ");
    document.body.appendChild(x);
}
</script>