<?php
/*
*     Auteur              :  RUSSOTTI Leandro.
*     Projet              :  fakeTPI.
*     Page                :  Page de fonctions.
*     Date début projet   :  27.04.2020.
*/

require_once('./inc/BDD/connexionBd.php');

$db = UserDbConnection();
setlocale(LC_ALL, "fr_FR.utf8", 'fra');

if (session_status() == PHP_SESSION_NONE)
{
  session_start();
}

//Function servant a verifier si on est log ou non
function isLogged()
{
    return isset($_SESSION['connect']);
}

// Fonction ajoutant un animal a la base.
function ajouterAnimal($typeAnimal,$prenomAnimal,$dateNaissanceAnimal)
{
  global $db;

  $insertNewAnimal = $db->prepare("INSERT INTO animaux(typeAnimal,prenomAnimal,dateNaissanceAnimal) VALUES(:typeAnimal, :prenomAnimal, :dateNaissanceAnimal)");
  $insertNewAnimal->bindParam(":typeAnimal",$typeAnimal,PDO::PARAM_STR);
  $insertNewAnimal->bindParam(":prenomAnimal",$prenomAnimal,PDO::PARAM_STR);
  $insertNewAnimal->bindParam(":dateNaissanceAnimal",$dateNaissanceAnimal);
  $insertNewAnimal->execute();
}

// Fonction supprimant un animal a la base.
function deleteAnimal($idAnimal)
{
  global $db;

  $deleteAnimal = $db->prepare('DELETE FROM animaux WHERE idAnimal = :idAnimal');
  $deleteAnimal->bindParam(":idAnimal",$idAnimal);
  $deleteAnimal->execute();
}

// Fonction Modifiant un animal a la base.
function editAnimal($idAnimal,$prenomAnimal,$dateNaissanceAnimal,$typeAnimal)
{
  global $db;

  $editAnimal = $db->prepare('UPDATE animaux SET typeAnimal = :typeAnimal, prenomAnimal = :prenomAnimal, dateNaissanceAnimal = :dateNaissanceAnimal WHERE idAnimal = :idAnimal');
  $editAnimal->bindParam(":idAnimal",$idAnimal);
  $editAnimal->bindParam(":prenomAnimal",$prenomAnimal);
  $editAnimal->bindParam(":dateNaissanceAnimal",$dateNaissanceAnimal);
  $editAnimal->bindParam(":typeAnimal",$typeAnimal);
  $editAnimal->execute();
}

// Fonction qui hash et salt le password.
function hashPassword($hash,$pwd)
{
  $email = md5($hash);
  $hashedPwd = md5($hash.$pwd);
  return $hashedPwd;
}

// Fonction servant a connecté l'user a la base.
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

// Fonction servant a convertir une date en age
function dateToAge($date)
{
  $date = new DateTime($date);
  $now = new DateTime();
  $interval = $now->diff($date);
  if ($interval->y <= 0) {
    return $interval->m." Mois";
  }
  else{
    return $interval->y." Années";
  }
  
}

// Fonction retournant tout les animauxs entrés en base
function getAllAnimaux()
{
  global $db; 
  $reqAnimaux = $db->query('SELECT idAnimal,typeAnimal,prenomAnimal,dateNaissanceAnimal FROM animaux');
  $animauxInfos = $reqAnimaux->fetchAll();
  return $animauxInfos;
}

// Fonction retournant tout les animauxs entrés en base
function getAnimauxByType($type)
{
  global $db; 
  $reqAnimaux = $db->prepare('SELECT idAnimal,typeAnimal,prenomAnimal,dateNaissanceAnimal FROM animaux WHERE typeAnimal = :typeAnimal');
  $reqAnimaux->bindParam(":typeAnimal",$type);
  $reqAnimaux->execute();
  $animauxInfos = $reqAnimaux->fetchAll();
  return $animauxInfos;
}

// Fonction retournant tout les animauxs entrés en base
function getAllAnimauxType()
{
  global $db; 
  $reqType = $db->query('SELECT distinct typeAnimal FROM animaux');
  $type = $reqType->fetchAll();
  return $type;
}

// Fonction affichants les animaux rentrés en base
function showSelectTypeAnimals()
{
  $resultType = "<select name='selectTypeAnimal'>";
  $type = getAllAnimauxType();
  foreach ($type as $t) 
  {
    $resultType.= "
    <option value='".$t{"typeAnimal"}."'>".ucfirst($t{"typeAnimal"})."</option>
    ";
  }
  $resultType .="</select>";
  return $resultType;
}

// Fonction affichants les animaux rentrés en base
function showAnimalsForUsers($typeAnimal = null)
{
  $resultAnimaux = "";
  $animaux = getAllAnimaux();
  foreach ($animaux as $a) {
    $resultAnimaux.= "
    <tr>
      <td>".ucfirst($a{"typeAnimal"})."</td>
      <td>".ucfirst($a{"prenomAnimal"})."</td>
      <td>".dateToAge($a{"dateNaissanceAnimal"})."</td>
    </tr>";
  }

  $datas = '';
  $datas .= '<div class="container">';
  $datas .=   '<div class="row">';
  $datas .=     '<div class="col-lg-12">';
  $datas .=       '<div class="shadow-lg card text-dark" style="background-color: #EEEEEE;">';
  $datas .=         '<div class="card-header text-light p-3 pl-4" style="background-color: #0e43ff"><h4>Listes des animaux</h4></div>';
  $datas .=         '<div class="card-body p-0 m-0">';
  $datas .=           '<table class="table table-hover">';
  $datas .=             '<thead>';
  $datas .=               '<tr>';
  $datas .=                 '<th>Type d\'animal</th>';
  $datas .=                 '<th>Prénom de l\'animal</th>';
  $datas .=                 '<th>Âge de l\'animal</th>';
  $datas .=               '</tr>';
  $datas .=             '</thead>';
  $datas .=             '<tbody>';
  $datas .=               $resultAnimaux;
  $datas .=             '</tbody>';
  $datas .=           '</table class="table">';
  $datas .=         '</div>';
  $datas .=       '</div>';
  $datas .=     '</div>';
  $datas .=   '</div>';
  $datas .= '</div>';

  return $datas;
}

// Fonction affichants les animaux rentrés en base
function showAnimalsForAdmins($typeAnimal = null)
{
  $resultAnimaux = "";
  if ($typeAnimal == null) {
    $animaux = getAllAnimaux();
  }
  else {
    $animaux = getAnimauxByType($typeAnimal);
  }

  foreach ($animaux as $a) {
    $resultAnimaux.= "
    <tr>
      <td>".ucfirst($a{"typeAnimal"})."</td>
      <td>".ucfirst($a{"prenomAnimal"})."</td>
      <td>".dateToAge($a{"dateNaissanceAnimal"})."</td>
      <td><li class=\"list-inline-item\">
      <button class=\"btn btn-success btn-sm rounded-0\" type=\"button\" data-toggle=\"modal\"data-dateAnimal=".$a{"dateNaissanceAnimal"}." data-idAnimal=".$a{"idAnimal"}." data-nameAnimal=".$a{"prenomAnimal"}." data-typeAnimal=".$a{"typeAnimal"}." data-placement=\"top\" title=\"Modifier\" data-target=\"#modalEdit\"><i class=\"fa fa-edit\"></i></button>
  </li>
  <li class=\"list-inline-item\">
      <button class=\"btn btn-danger btn-sm rounded-0\" type=\"button\" data-toggle=\"modal\" data-idAnimal=".$a{"idAnimal"}." data-nameAnimal=".$a{"prenomAnimal"}." data-placement=\"top\" title=\"Supprimer\" data-target=\"#modalDelete\"><i class=\"fa fa-trash\"></i></button>
  </li>
  </td>
    </tr>";
  }

  $datas = '';
  $datas .= '<div class="container">';
  $datas .=   '<div class="row">';
  $datas .=     '<div class="col-lg-12">';
  $datas .=       '<div class="shadow-lg card text-dark" style="background-color: #EEEEEE;">';
  $datas .=         '<div class="card-header text-light p-3 pl-4" style="background-color: #0e43ff"><h4>Listes des animaux</h4></div>';
  $datas .=         '<div class="card-body p-0 m-0">';
  $datas .=           '<table class="table table-hover">';
  $datas .=             '<thead>';
  $datas .=               '<tr>';
  $datas .=                 '<th>Type d\'animal</th>';
  $datas .=                 '<th>Prénom de l\'animal</th>';
  $datas .=                 '<th>Âge de l\'animal</th>';
  $datas .=                 '<th>Administration</th>';
  $datas .=               '</tr>';
  $datas .=             '</thead>';
  $datas .=             '<tbody>';
  $datas .=               $resultAnimaux;
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