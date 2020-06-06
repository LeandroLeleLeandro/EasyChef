<?php
/*
*     Auteur              :  RUSSOTTI Leandro.
*     Projet              :  EasyChef.
*     Page                :  Barre de navigation pour les user connectés.
*     Date début projet   :  25.05.2020.
*/
?>
<div class="container-fluid mb-5 text-light" style="background-color: #2C2416;">
    <nav class="container navbar navbar-expand">
        <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
            <h4><a class="nav-link text-light" href=".\index.php">EasyChef</a></h4>
            </li>
        </ul>
        <span class="navbar-text">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item mr-2">
                    <h5><a href="admin.php" class="nav-link text-light">Administration</a></h5>
                </li>
                <li class="nav-item mr-2">
                    <h5><a href="./recipe.php?user=<?= getIdUserFromPseudo($_SESSION['pseudo']) ?>" class="nav-link text-light">Mes recettes</a></h5>
                </li>
                <li class="nav-item mr-2">
                    <h5><a href="./rate.php?user=<?= getIdUserFromPseudo($_SESSION['pseudo'])?>" class="nav-link text-light">Mes avis</a></h5>
                </li>
                <li class="nav-item mr-2">
                    <h5><a href="./parameters.php?idUser=<?= getIdUserFromPseudo($_SESSION['pseudo'])?>" class="nav-link text-light">Paramètres</a></h5>
                </li>
                <li class="nav-item mr-2">
                    <h5><a href="./logout.php" class="nav-link text-light">Déconnexion</a></h5>
                </li>
            </ul>
        </span>
        </div>
    </nav>
</div>

