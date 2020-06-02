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
 * Fonction servant a savoir si l'utilisateur est administrateur ou non.
 *
 * @param string $pseudo Le pseudo de l'utilisateur
 * @return bool True s'il est admin.
 */
function isAdministrator($pseudo)
{
  global $db;

  $reqAdmin = $db->prepare("SELECT admin FROM user WHERE pseudo = :pseudo");
  $reqAdmin->bindParam(":pseudo",$pseudo,PDO::PARAM_STR);

  $reqAdmin->execute();

  $admin = $reqAdmin->fetch();

  if($admin[0] == 1)
  {
      return true;
  }
  else
  {
      return false;
  }
}

/**
 * Fonction servant a connecté l'user a la base.
 *
 * @param string $pseudo Le nom de l'user qui tente de se connecté.
 * @param string $password Le mot de passe de l'user qui tente de se connecté.
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

/**
 * Fonction servant a obtenir toutes les recettes validés.
 *
 * @return array Tableau contenant toutes les recettes validées
 */
function getAllRecettes()
{
  global $db; 

  $reqRecettes = $db->query('SELECT idRecipe,idUser,title,description,timeRequired,isValid,lastChangeDate FROM recipe WHERE isValid = 1');
  $recettes = $reqRecettes->fetchAll();
  return $recettes;
}

/**
 * Fonction servant a obtenir toutes les recettes validés, contenant un certain mot.
 *
 * @param string $researchRecipe le mot qui doit être présent dans la recette
 * @return array Tableau contenant les recettes validés contenant un certain mot.
 */
function getRecipeWithResearch($researchRecipe)
{
  global $db; 

  $researchRecipe = "%".$researchRecipe."%";
  $reqRecettes = $db->prepare('SELECT idRecipe,idUser,title,description,timeRequired,isValid,lastChangeDate FROM recipe WHERE isValid = 1 AND title LIKE :researchTitle OR description LIKE :researchDescription');
  $reqRecettes->bindParam(":researchTitle",$researchRecipe,PDO::PARAM_STR);
  $reqRecettes->bindParam(":researchDescription",$researchRecipe,PDO::PARAM_STR);
  $reqRecettes->execute();
  $recettes = $reqRecettes->fetchAll();
  return $recettes;
}

/**
 * Fonction retournant les recettes disponible sous forme de tableau HTML
 *
 * @param string chaine facultative contenant le mot a rechercher.
 * @return string chaine contenant sous forme de tableau HTML les recettes du site.
 */
function showRecetteForUsers($researchRecipe = null)
{
  $resultRecette = "";

  if ($researchRecipe == null) 
  {
    $recettes = getAllRecettes();
  }
  else
  {
    $recettes = getRecipeWithResearch($researchRecipe);
  }
  
  foreach ($recettes as $r) 
  {
    $resultRecette .= "<tr>";
    $resultRecette .= "<td>".ucfirst($r{"title"})."</td>";
    $resultRecette .= "<td>".$r{"timeRequired"}." Minutes</td>";
    $resultRecette .= "<td>".changeDateFormat($r{"lastChangeDate"})."</td>";
    $resultRecette .= "<td><a href=\"detailsRecette.php?idRecette=".$r{"idRecipe"}."\" title=\"Plus de détails\"><i class=\"fa fa-info-circle\"></i></a></td>";
    $resultRecette .= "</tr>";
  }

  $datas = '';

  // Affichage si aucune recette a été trouvé
  if(!$resultRecette)
  {
    $datas .= '<div class="container">';
    $datas .=   '<div class="row">';
    $datas .=     '<div class="col-lg-12">';
    $datas .=       '<div class="shadow-lg card text-dark" style="background-color: #EEEEEE;">';
    $datas .=         '<div class="card-header text-light p-3 pl-4" style="background-color: 	#F4A460"><h4>Résultat pour votre recherche : "'.$researchRecipe.'"</h4></div>';
    $datas .=         '<div class="card-body p-0 m-0">';
    $datas .=         '<h4 class="p-4 text-danger">Votre recherche à donné aucun résultat.</h4>';
    $datas .=         '</div>';
    $datas .=       '</div>';
    $datas .=     '</div>';
    $datas .=   '</div>';
    $datas .= '</div>';
  }
  // Affichage si des recettes ont été trouvés
  else
  {
    
    $datas .= '<div class="container">';
    $datas .=   '<div class="row">';
    $datas .=     '<div class="col-lg-12">';
    $datas .=       '<div class="shadow-lg card text-dark" style="background-color: #EEEEEE;">';
    if ($researchRecipe != null) 
    {
      $datas .=         '<div class="card-header text-light p-3 pl-4" style="background-color: 	#F4A460"><h4>Résultat pour votre recherche : "'.$researchRecipe.'"</h4></div>';
    }
    else
    {
      $datas .=         '<div class="card-header text-light p-3 pl-4" style="background-color: 	#F4A460"><h4>Listes des recettes</h4></div>';
    }
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
  }
  

  return $datas;
}

/**
 * Fonction changeant le format de la date.
 *
 * @param string $date la date qu'on veut formater
 * @return string retourne la date formatée sous la forme suivante :
 */
function changeDateFormat($date)
{
  return strftime("%d %B %Y", strtotime($date));
}

/**
 * Fonction servant a savoir si une recette existe ou non selon son ID
 *
 * @param int $idRecette l'id de la recette a vérifier
 * @return bool true si la recette existe en base.
 */
function recetteExists($idRecipe)
{
  global $db;

  $reqRecette = $db->prepare("SELECT idRecipe FROM recipe WHERE idRecipe = :idRecipe AND isValid = 1");
  $reqRecette->bindParam(":idRecipe",$idRecipe,PDO::PARAM_INT);
  $reqRecette->execute();

  $recettesExist = $reqRecette->rowCount();

  if($recettesExist == 1)
  {
      return true;
  }
  else
  {
      return false;
  }
}

/**
 * Fonction retournant l'image d'une recette
 *
 * @param int $idRecipe l'id de la recette dont on veut l'image
 * @return string lien vers l'img
 */
function getRecettePictureFromId($idRecipe)
{
  global $db; 

  $reqPicture = $db->prepare('SELECT path FROM picture WHERE idRecipe = :idRecipe');
  $reqPicture->bindParam(":idRecipe",$idRecipe,PDO::PARAM_INT);
  $reqPicture->execute();

  $image = $reqPicture->fetch();
  return $image;
}

/**
 * Fonction pour recuperé les ingredients d'une recette
 *
 * @param int $idRecipe id de la recette voulu
 * @return void
 */
function getRecetteIngredientsFromId($idRecipe)
{
  global $db; 

  $reqIngredient = $db->prepare('SELECT name,quantity,unity FROM ingredient WHERE idRecipe = :idRecipe');
  $reqIngredient->bindParam(":idRecipe",$idRecipe,PDO::PARAM_INT);
  $reqIngredient->execute();

  $ingredients = $reqIngredient->fetchAll();
  return $ingredients;
}

/**
 * Fonction retournant les informations d'une recette
 *
 * @param int $idRecipe l'id de la recette
 * @return array les infos de la recette
 */
function getInformationsOfRecipe($idRecipe)
{
  global $db; 

  $reqInfos = $db->prepare('SELECT pseudo,title,description,timeRequired,lastChangeDate FROM recipe,user WHERE idRecipe = :idRecipe AND recipe.idUser = user.idUser');
  $reqInfos->bindParam(":idRecipe",$idRecipe,PDO::PARAM_INT);
  $reqInfos->execute();

  $informations = $reqInfos->fetch();
  return $informations;
}

/**
 * Fonction affichant les ingrédiant sous forme de tableau html
 *
 * @param int $idRecipe id de la recette dont les ingrédiants sont voulu
 * @return void
 */
function showIngredient($idRecipe)
{ 
  $datas = '<ul class="list-group shadow-lg">';
  $datas .= '<li class="list-group-item"  style="background-color: #BAA378; color: white;"><h4>Ingrédients</h4></li>';
  $ingredients = getRecetteIngredientsFromId($idRecipe);
  foreach ($ingredients as $i) 
  {
    if ($i{"unity"} != "") 
    {
      $datas .= "<li class=\"list-group-item\">".$i{"quantity"}." ".$i{"unity"}." de ".mb_strtolower($i{"name"})."</li>";

    }
  }
  $datas .= "</ul>";
  return $datas;
}

/**
 * Fonction retournant les informations d'une recette
 *
 * @param int $idRecipe l'id de la recette
 * @return string La listes des informations
 */
function showInformations($idRecipe)
{
  $informations = getInformationsOfRecipe($idRecipe); 

  $datas = '<ul class="list-group shadow-lg">';
  $datas .= '<li class="list-group-item"  style="background-color: #BAA378; color: white;"><h4>Informations de la recette</h4></li>';
  $datas .= "<li class=\"list-group-item\"><h5>Recette postée par : <small>".ucfirst($informations{"pseudo"})."</small></h5></li>";
  $datas .= "<li class=\"list-group-item\"><h5>Dernière modification le : <small>".changeDateFormat($informations{"lastChangeDate"})."</small></h5></li>";
  $datas .= "<li class=\"list-group-item\"><h5>Temps de cuisson : <small>".$informations{"timeRequired"}." minutes.</small></h5></li>";
  $datas .= "<li class=\"list-group-item\"><h5>Marche a suivre : <small>".$informations{"description"}."</small></h5></li>";
  $datas .= "</ul>";

  return $datas;
}

/**
 * Fonction retournant les notes d'une recette
 *
 * @param int $idRecipe id de la recette dont les notes sont voulues
 * @return void
 */
function getRecetteRateFromId($idRecipe)
{
  global $db; 

  $reqRate = $db->prepare('SELECT description,rating,date FROM rate WHERE idRecipe = :idRecipe');
  $reqRate->bindParam(":idRecipe",$idRecipe,PDO::PARAM_INT);
  $reqRate->execute();

  $rates = $reqRate->fetchAll();
  return $rates;
}

/**
 * Fonction retournant le nombre d'avis différent d'une recette
 *
 * @param int $idRecipe id de la recette
 * @return int nombre d'avis
 */
function getNumberOfRate($idRecipe)
{
  global $db; 

  $reqRate = $db->prepare('SELECT rating FROM rate WHERE idRecipe = :idRecipe');
  $reqRate->bindParam(":idRecipe",$idRecipe,PDO::PARAM_INT);
  $reqRate->execute();

  $nbOfRate = $reqRate->rowCount();
  return $nbOfRate;
}

/**
 * Fonction retournant la moyenne des notes d'une recette
 *
 * @param int $idRecipe l'id de la recette dont nous voulons la moyenne
 * @return int retourne la moyenne des notes
 */
function getMoyenneOfRates($idRecipe)
{
  $moy = 0;
  $temp = 0;
  $rates = getRecetteRateFromId($idRecipe);
  foreach ($rates as $r) 
  {
   $moy += $r{"rating"};
   $temp ++;
  }

  $moy = $moy/$temp;
  $moy = round($moy, 1, PHP_ROUND_HALF_ODD);
  
  return $moy;
}

/**
 * Fonction affichant la note moyenne d'une recette
 *
 * @param int $idRecipe L'id de la recette dont nous voulons la note moyenne
 * @return string l'affichage a echo
 */
function showAvgRates($idRecipe)
{
  $rate = intval(getMoyenneOfRates($idRecipe));
  $diffWithMaxRate = 5-$rate;
  $datas = "";
  $datas .=   '<h4 class="pt-2">'.getMoyenneOfRates($idRecipe).'/5&nbsp;&nbsp;';

  for ($i=0; $i < $rate; $i++) 
  { 
    $datas .= '<i class="fa fa-star" style="color: #FDCC0D; font-size: 25px;"></i>';
  }
  for ($i=0; $i < $diffWithMaxRate; $i++) { 
    $datas .=  '<i class="fa fa-star" style="color: black; font-size: 25px;"></i>';
  }
    
  $datas .= ' sur '.getNumberOfRate($idRecipe).' avis.</h4>';
  return $datas;
}

/**
 * Fonction retournant le nom d'une recette depuis son id
 *
 * @param int $idRecipe l'id de la recette dont nous voulons le nom
 * @return string le nom de la recette
 */
function getNameOfRecipe($idRecipe)
{
  global $db; 

  $reqNameRecipe = $db->prepare('SELECT title FROM recipe WHERE idRecipe = :idRecipe');
  $reqNameRecipe->bindParam(":idRecipe",$idRecipe,PDO::PARAM_INT);
  $reqNameRecipe->execute();

  $name = $reqNameRecipe->fetch();
  return $name[0];
}

/**
 * Fonction retournant les commentaires d'une recettes depuis son ID
 *
 * @param int $idRecipe l'id de la recette.
 * @return array commentaires de la recette.
 */
function getCommentsOfRecipe($idRecipe)
{
  global $db; 

  $reqComments = $db->prepare('SELECT pseudo,description,rating,date FROM rate,user WHERE user.idUser = rate.idUser AND idRecipe = :idRecipe');
  $reqComments->bindParam(":idRecipe",$idRecipe,PDO::PARAM_INT);
  $reqComments->execute();

  $comments = $reqComments->fetchAll();
  return $comments;
}

/**
 * Fonction retournant tout les avis d'une recette
 *
 * @param int $idRecipe id de la recette
 * @return string Les commentaires.
 */
function showAllComments($idRecipe)
{
  $datas = "";
  $datas .= '<ul class="list-group shadow-lg">';
  $datas .=   '<li class="list-group-item" style="background-color: #BAA378; color: white;"><h4>Avis de la recette :</h4></li>';
  
  $comments = getCommentsOfRecipe($idRecipe);
  foreach ($comments as $c) 
  {
    $datas .= '<li class="list-group-item"><h4><span class="text-info">'.ucfirst($c{"pseudo"}).'</span> '.getStarsFromNumber($c{"rating"}).'  <span style="font-size : 20px;">le '.changeDateFormat($c{"date"}).'</span><br><small>'.$c{"description"}.'</small></h4></li>';
  }
                                                
  $datas .= '<ul>';

  return $datas;
}

/**
 * Fonction retournant des étoiles en fonction d'un nombre
 *
 * @param int $number le nombre d'étoiles retournés
 * @return string Les étoiles.
 */
function getStarsFromNumber($number)
{
  $datas = "";

  for ($i=0; $i < $number; $i++) { 
    $datas .= '<i class="fa fa-star" style="color: #FDCC0D; font-size: 25px;"></i>';
  }

  return $datas;
}

/**
 * Fonction retournant true ou false en fonction de si l'utilisateur est l'auteur de la recette ou non.
 *
 * @param string $pseudo pseudo de l'utilisateur
 * @param int $idRecipe id de l'utilisateur
 * @return bool true si l'utilisateur est l'auteur
 */
function isTheAuthorOfRecipe($pseudo,$idRecipe)
{
  global $db;

  $reqAuthor = $db->prepare("SELECT * FROM user,recipe WHERE pseudo = :pseudo AND idRecipe = :idRecipe AND recipe.idUser = user.idUser");
  $reqAuthor->bindParam(":pseudo",$pseudo,PDO::PARAM_STR);
  $reqAuthor->bindParam(":idRecipe",$idRecipe,PDO::PARAM_INT);
  $reqAuthor->execute();
  $isAuthor = $reqAuthor->rowCount();

  if($isAuthor == 1)
  {
      return true;
  }
  else
  {
      return false;
  }
}

/**
 * Fonction insérant en base de donnée un nouvel avis.
 *
 * @param int $idUser id de l'utilisateur
 * @param int $idRecipe id de la recette
 * @param int $rate note de la recette
 * @param string $description description de l'avis
 * @return void
 */
function insertRate($idUser,$idRecipe,$rate,$description)
{
  global $db;

  $insertRate = $db->prepare("INSERT INTO rate(idUser,idRecipe,rating,description) VALUES(:idUser, :idRecipe, :rating, :description)");
  $insertRate->bindParam(":idUser",$idUser,PDO::PARAM_INT);
  $insertRate->bindParam(":idRecipe",$idRecipe,PDO::PARAM_INT);
  $insertRate->bindParam(":rating",$rate,PDO::PARAM_INT);
  $insertRate->bindParam(":description",$description,PDO::PARAM_STR);
  $insertRate->execute();
}

/**
 * Fonction retournant l'id d'un user correspondant a un pseudo.
 *
 * @param string $pseudo pseudo de l'utilisateur
 * @return int l'id de l'utilisateur
 */
function getIdUserFromPseudo($pseudo)
{
  global $db; 

  $reqId = $db->prepare('SELECT idUser FROM user WHERE pseudo = :pseudo');
  $reqId->bindParam(":pseudo",$pseudo,PDO::PARAM_STR);
  $reqId->execute();

  $id = $reqId->fetch();
  return $id[0];
}
?>