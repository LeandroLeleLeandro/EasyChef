<?php
/*
*     Auteur              :  RUSSOTTI Leandro.
*     Projet              :  fakeTPI.
*     Page                :  Accueil.
*     Date début projet   :  27.04.2020.
*/

require_once('./inc/function.php');

//Affiche les erreurs si il y en a
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$btnSearchType = FILTER_INPUT(INPUT_POST,"btnSearchTypeAnimal");

if ($btnSearchType) 
{
    $selectedTypeAnimal = FILTER_INPUT(INPUT_POST,"selectTypeAnimal");
}
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Salu - indexent</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="style/style.css">
        
    </head>
    <?php 
        if (isLogged())
        {
            include "inc/navbar/navbarLogged.php";
        }
        else
        {
            include "inc/navbar/navbarNotLogged.php";
        }
    ?>
    <body>
        <div class="formulaireAnimal mb-5">
            <?php
                include "inc/form/formulaireAjoutAnimal.php";
            ?>
        </div>       

        <div class="rechercheAnimal mb-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="shadow-lg card text-dark" style="background-color: #EEEEEE;">
                            <div class="card-header text-light p-3 pl-4" style="background-color: #12aa13"><h4>Rechercher un animal</h4></div> 
                            <div class="card-body">
                                <form action="" method="post">
                                    
                                        <?php echo showSelectTypeAnimals(); ?>
                                     <input type="submit" value="Rechercher" name="btnSearchTypeAnimal">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>   

        <div class="listesAnimaux">
            <?php
                if (!isLogged()){
                    echo showAnimalsForUsers();
                } else {
                    if (isset($selectedTypeAnimal)) {
                        echo showAnimalsForAdmins($selectedTypeAnimal);
                    }
                    else {
                        echo showAnimalsForAdmins();
                    }
                    
                }  
            ?>
        </div>
        <div class="modals">
        <?php
            include "inc/modal/modalLogout.php";
            include "inc/modal/modalDeleteAnimals.php";
            include "inc/modal/modalEditAnimal.php"; 
        ?>
        </div>
    </body>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    <script>
    $('#modalDelete').on('show.bs.modal', function (e) {
        var button = $(e.relatedTarget)
        var idAnimal = button.data('idanimal')
        var nameAnimal = button.data('nameanimal')

        document.getElementById("hiddenDeleteIdAnimal").value = idAnimal;
        document.getElementById("modalNomAnimal").innerHTML = nameAnimal; 
    });

    $('#modalEdit').on('show.bs.modal', function (e) {
        var button = $(e.relatedTarget)
        var idAnimal = button.data('idanimal')
        var nameAnimal = button.data('nameanimal')
        var typeAnimal = button.data('typeanimal')
        var dateAnimal = button.data('dateanimal')

        document.getElementById("hiddenEditIdAnimal").value = idAnimal
        document.getElementById("nouveauTypeAnimal").value = typeAnimal
        document.getElementById("nouveauPrenomAnimal").value = nameAnimal
        document.getElementById("nouvelleDateAnimal").value = dateAnimal
    });
</script>
</html>