<?php
/*
*     Auteur              :  RUSSOTTI Leandro.
*     Projet              :  EasyChef.
*     Page                :  Page de détails.
*     Date début projet   :  25.05.2020.
*/

//Page nécessaire au fonctionnement.
require_once('./inc/function.php');

//Affiche les erreurs si il y en a
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$idRecette = FILTER_INPUT(INPUT_GET,"idRecette",FILTER_VALIDATE_INT);

if ($idRecette)
{
    if (recetteExists($idRecette))
    {
        
    }
    else
    {
        header("Location: index.php");
        exit;
    }
}
else 
{
    header("Location: index.php");
    exit;
}

$pathImg = getRecettePictureFromId($idRecette);


?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>EasyChef - détails</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="style/style.css">      
    </head>
    <body>
        <?php
            if (isLogged())
            {
                include('inc/navbar/navbarLogged.php');
            }
            else
            {
                include('inc/navbar/navbarNotLogged.php');
            }
        ?>
        <div class="details">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-10" style="margin: auto;">
                        <div class="shadow-lg card text-dark" style="background-color: #EEEEEE;">
                            <div class="card-body p-0 m-0">
                                <div class="container-fluid p-0">
                                    <div class="row p-0">
                                        <div class="col" style="margin: auto;">
                                            <img class="m-4 shadow-lg float-left" align="center" src="<?= $pathImg[0]; ?>" alt="photo de la recette" style="width: 100%;">
                                            
                                        </div>
                                        <div class="col">
                                            <?= showIngredient($idRecette); ?>
                                        </div>
                                        <div class="col">
                                            <?= showIngredient($idRecette); ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row p-0 mt-5">
                                        <div class="col">
                                        <?= getMoyenneOfRates($idRecette); ?>
                                        </div>
                                        <div class="col">
                                        2 of 3
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                 </div>
            </div>  
        </div>
    </body>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</html>