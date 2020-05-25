<?php
/*
*     Auteur              :  RUSSOTTI Leandro.
*     Projet              :  EasyChef.
*     Page                :  Page de déconnexion.
*     Date début projet   :  25.05.2020.
*/

session_start();
$_SESSION = array();

if(ini_get("session.use_cookies")){
    setcookie(session_name(), '', 0);
}

session_destroy();
header("Location: index.php");