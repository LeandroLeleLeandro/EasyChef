<?php
/*
*     Auteur              :  RUSSOTTI Leandro.
*     Projet              :  EasyChef.
*     Page                :  Page mes avis postés.
*     Date début projet   :  25.05.2020.
*/

//Page nécessaire au fonctionnement.
require_once('./inc/function.php');

//Affiche les erreurs si il y en a
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Récupère l'id dans le get
$idUserGet = FILTER_INPUT(INPUT_GET,"user",FILTER_VALIDATE_INT);
$idUserLogged = getIdUserFromPseudo($_SESSION["pseudo"]);

// Vérifie que l'id du get est le même que l'id de l'utilisateur, sinon redirige a l'accueil.
if ($idUserGet != $idUserLogged) 
{
    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>EasyChef - Mes Avis</title> 
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link rel="stylesheet" href="style/style.css">      
    </head>
    <body>
        <?php
            if (isLogged())
            {
                if (isAdministrator($_SESSION["pseudo"])) 
                {
                    include('inc/navbar/navbarAdmin.php');
                }
                else
                {
                    include('inc/navbar/navbarLogged.php');
                }
            }
            else
            {
                include('inc/navbar/navbarNotLogged.php');
            }
        ?>
        
        <?php if (userHasNeverPostRate($idUserLogged)): ?>
            <div>  
                <?= showAllRateOfUser($idUserLogged); ?>
            </div>
        <?php else: ?>
            <div class="container">
            <div class="row">
                <div class="col-lg-12 mb-5">
                    <div class="shadow-lg card text-dark" style="background-color: #EEEEEE;">             
                        <div class="alert alert-danger" role="alert">
                            <h3 class="alert-heading">Vous n'avez postez aucun avis.</h3>
                            <hr> 
                            <p>Retourner sur cette page quand vous aurez postez au minimum un avis !</p>
                        </div>                            
                    </div>        
                </div>
            </div>
        </div>
        <?php endif; ?>
    </body>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</html>