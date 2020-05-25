<?php
/*
*     Auteur              :  RUSSOTTI Leandro.
*     Projet              :  EasyChef.
*     Page                :  Page de fonctions.
*     Date début projet   :  25.05.2020.
*/

require_once('./inc/bdd/connexionBd.php');

$db = UserDbConnection();
setlocale(LC_ALL, "fr_FR.utf8", 'fra');

if (session_status() == PHP_SESSION_NONE)
{
  session_start();
}

/**
 * Fonction vérifiant si un user est connecté ou non
 * @return bool true si l'user est connecté
 */
function isLogged()
{
    return isset($_SESSION['connect']);
}

/**
 * Fonction servant a connecté l'user a la base.
 *
 * @param string $name Le nom de l'user qui tente de se connecté.
 * @param string $pwd Le mot de passe de l'user qui tente de se connecté.
 * @return void
 */
function connectUser($name,$pwd)
{
  global $db;

  $requser = $db->prepare("SELECT * FROM users WHERE surnameUser = ? AND pwdUser = ?");
  $requser->execute(array($name,$pwd));
  $userexist = $requser->rowCount();

  if($userexist == 1)
  {
      return true;
  }
  else
  {
      return false;
  }
}

?>