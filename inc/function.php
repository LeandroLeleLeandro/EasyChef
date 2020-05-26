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
function connectUser($pseudo,$password)
{
  global $db;

  $reqConnect = $db->prepare("SELECT * FROM user WHERE pseudo = :pseudo AND password = :password");
  $reqConnect->bindParam(":pseudo",$pseudo,PDO::PARAM_STR);
  $reqConnect->bindParam(":password",$password,PDO::PARAM_STR);
  $reqConnect->execute();
  $userexist = $reqConnect->rowCount();

  if($userexist == 1)
  {
      return true;
  }
  else
  {
      return false;
  }
}

/**
 * Fonction vérifiant si un pseudonyme est déjà enrengistré ou non
 *
 * @param string $pseudo le pseudo a vérifier
 * @return bool true si le pseudo existe déjà
 */
function pseudonymeAlreadyExist($pseudo)
{
  global $db;

  $reqPseudo = $db->prepare("SELECT pseudo FROM user WHERE pseudo = :pseudo");
  $reqPseudo->bindParam(":pseudo",$pseudo,PDO::PARAM_STR);
  $reqPseudo->execute();

  $userexist = $reqPseudo->rowCount();

  if($userexist == 1)
  {
      return true;
  }
  else
  {
      return false;
  }
}

/**
 * Fonction insérant les nouveaux membres dans la base de donnée
 *
 * @param string $password Le mot de passe hashé de l'user
 * @param string $email L'email de l'utilisateur
 * @param string $pseudo Le pseudo de l'utilisateur
 * @return void
 */
function insertNewUser($password,$email,$pseudo)
{
  global $db;

  $insertNewUser = $db->prepare("INSERT INTO user(password,email,pseudo) VALUES(:password, :email, :pseudo)");
  $insertNewUser->bindParam(":password",$password,PDO::PARAM_STR);
  $insertNewUser->bindParam(":email",$email,PDO::PARAM_STR);
  $insertNewUser->bindParam(":pseudo",$pseudo,PDO::PARAM_STR);
  $insertNewUser->execute();
}

function getAllRecettes()
{
  global $db; 

  $reqRecettes = $db->query('SELECT idRecipe,idUser,title,description,timeRequired,isValid,lastChangeDate FROM recipe');
  $recettes = $reqRecettes->fetchAll();
  return $recettes;
}


function showRecetteForUsers()
{
  $resultRecette = "";
  $recettes = getAllRecettes();
  foreach ($recettes as $r) {
    $resultRecette.= "
    <tr>
      <td>".ucfirst($r{"title"})."</td>
      <td>".$r{"timeRequired"}." Minutes</td>
      <td>".$r{"lastChangeDate"}."</td>
      <td><li class=\"list-inline-item\">
      <button class=\"btn btn-info btn-sm rounded-0\" type=\"button\" title=\"Plus de détails\"><i class=\"fa fa-info-circle\"></i></button>
  </li>
 
  </td>
    </tr>";
  }

  $datas = '';
  $datas .= '<div class="container">';
  $datas .=   '<div class="row">';
  $datas .=     '<div class="col-lg-12">';
  $datas .=       '<div class="shadow-lg card text-dark" style="background-color: #EEEEEE;">';
  $datas .=         '<div class="card-header text-light p-3 pl-4" style="background-color: 	#F4A460"><h4>Listes des recettes</h4></div>';
  $datas .=         '<div class="card-body p-0 m-0">';
  $datas .=           '<table class="table table-hover">';
  $datas .=             '<thead>';
  $datas .=               '<tr>';
  $datas .=                 '<th>Nom de la recette</th>';
  $datas .=                 '<th>Temps de préparation</th>';
  $datas .=                 '<th>Posté le</th>';
  $datas .=                 '<th>Plus de détails</th>';
  $datas .=               '</tr>';
  $datas .=             '</thead>';
  $datas .=             '<tbody>';
  $datas .=               $resultRecette;
  $datas .=             '</tbody>';
  $datas .=           '</table class="table">';
  $datas .=         '</div>';
  $datas .=       '</div>';
  $datas .=     '</div>';
  $datas .=   '</div>';
  $datas .= '</div>';

  return $datas;
}
?>