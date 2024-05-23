<?php
require_once "connection.php";
class ModelDocentes
{
  //  Obtener todos los usuarios
  public static function mdlGetAllDocentes($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT
    usuario.idUsuario, 
    usuario.correoUsuario, 
    usuario.nombreUsuario, 
    usuario.apellidoUsuario, 
    usuario.estadoUsuario, 
    usuario.ultimaConexion, 
    tipo_usuario.descripcionTipoUsuario, 
    personal.idPersonal
  FROM
    $tabla
    INNER JOIN
    tipo_usuario
    ON 
      usuario.idTipoUsuario = tipo_usuario.idTipoUsuario
    INNER JOIN
    personal
    ON 
      usuario.idUsuario = personal.idUsuario
  WHERE
    usuario.idTipoUsuario = 2
  ORDER BY
    usuario.idUsuario DESC");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  //  Obtener tipo de usuarios
  public static function mdlGetTipoUsuarios($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT tipo_usuario.idTipoUsuario, tipo_usuario.descripcionTipoUsuario FROM $tabla");
    $statement->execute();
    return $statement->fetchAll();
  }
}
