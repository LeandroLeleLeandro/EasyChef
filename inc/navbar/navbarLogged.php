<?php
/*
*     Auteur              :  RUSSOTTI Leandro.
*     Projet              :  EasyChef.
*     Page                :  Barre de navigation pour les user connectés.
*     Date début projet   :  25.05.2020.
*/
?>
<div class="container-fluid mb-5 text-light" style="background-color: #8B4513;">
    <nav class="container navbar navbar-expand">
        <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
            <h4><a class="nav-link text-light" href=".\index.php">EasyChef</a></h4>
            </li>
            <li class="nav-item active">
            <h4 class="nav-link text-light">connecté en tant que <a href=""> <span style="color: #DAA520"><?= ucfirst($_SESSION["pseudo"]);?></span></a></h4>
            </li>
        </ul>
        <span class="navbar-text">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <h5><a href="./logout.php" class="nav-link text-light">Déconnexion</a></h5>
                </li>
            </ul>
        </span>
        </div>
    </nav>
</div>

