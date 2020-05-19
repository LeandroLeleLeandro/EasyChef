<?php
/*
*     Auteur              :  RUSSOTTI Leandro.
*     Projet              :  fakeTPI.
*     Page                :  Connexion a la base de donnée.
*     Date début projet   :  27.04.2020.
*/

require_once "informationBd.php";

function UserDbConnection()
{
  static $dbb = null;

  if ($dbb === null) 
  {
      try 
      {
          $dbb = new PDO("mysql:host=" . SERVER . ";port=". PORT .";dbname=" . DATABASE_NAME, PSEUDO, PWD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
          $dbb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } 
      catch (PDOException $e) 
      {
          die('Erreur : ' . $e->getMessage());
      }
  }

  return $dbb;
}