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
    $statement = Connection::conn()->prepare("SELECT grado.idGrado, grado.descripcionGrado FROM $tabla");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  //  Obtener todos los grados por nivel
  public static function mdlGetGradosByNivel($tabla, $codNivel)
  {
    $statement = Connection::conn()->prepare("SELECT grado.idGrado, grado.descripcionGrado FROM $tabla WHERE idNivel = :idNivel");
    $statement->bindParam(":idNivel", $codNivel, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Obtener todos los grados por nivel
   * 
   * @return array/string $respuesta Retorna un array con los datos de los grados o un string con un mensaje de error.
   */
  public static function mdlGetAllGradosByNivel($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT grado.idGrado, grado.descripcionGrado, nivel.descripcionNivel FROM $tabla AS grado INNER JOIN nivel ON grado.idNivel = nivel.idNivel");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
}
