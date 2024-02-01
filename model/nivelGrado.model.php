<?php
require_once "connection.php";

class ModelNivelGrado
{
  //  Obtener todos los niveles
  public static function mdlGetAllNiveles($tabla)
  {
    
  }

  //  Obtener todos los grados
  public static function mdlGetAllGrados($tabla)
  {
    
  }

  //  Obtener todos los grados por nivel
  public static function mdlGetGradosByNivel($tabla, $codNivel)
  {
    $statement = Connection::conn()->prepare("SELECT grado.idGrado, grado.descripcionGrado FROM $tabla WHERE idNivel = :idNivel");
    $statement->bindParam(":idNivel", $codNivel, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll();
  }
}