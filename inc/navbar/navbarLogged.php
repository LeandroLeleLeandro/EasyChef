<?php
/*
*     Auteur              :  RUSSOTTI Leandro.
*     Projet              :  fakeTPI.
*     Page                :  Barre de navigation user connectés.
*     Date début projet   :  27.04.2020.
*/
?>
<div class="container-fluid mb-5 text-light" style="background-color: orange;">
    <nav class="container navbar navbar-expand">
        <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
            <h4><a class="nav-link text-light" href="">Bonjour <span style="color: 	#bb0a1e"><?= ucfirst($_SESSION["surname"]);?></span></a></h4>
            </li>
        </ul>
        <span class="navbar-text">
            <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <h5><a class="nav-link text-light" data-toggle="modal" data-target="#modalLogout">Déconnexion</a></h5>
            </li>
            </ul>
        </span>
        </div>
    </nav>
</div>
