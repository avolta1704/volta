<?php
require_once "connection.php";
class ModelPersonal
{
  //  Obtener todo el personal
  public static function mdlGetAllPersonal($table)
  {
    $statement = Connection::conn()->prepare("SELECT * FROM $table");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
  
 /* obtener el ultimo usuario creado y su id */
  public static function mdlUltimoUsuarioCreado($table)
  {
    $statement = Connection::conn()->prepare("SELECT usuario.idUsuario
    FROM usuario
    ORDER BY usuario.idUsuario DESC
    LIMIT 1");
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }

//crear personal
  public static function mdlCrearUsuarioPersonal($table, $dataUsuarioPersonal)
  {
    $statement = Connection::conn()->prepare("INSERT INTO $table (idUsuario, idTipoPersonal, correoPersonal, nombrePersonal, apellidoPersonal, fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion)
     VALUES(:idUsuario, :idTipoUsuario, :correoUsuario, :nombreUsuario, :apellidoUsuario, :fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion)");

    $statement->bindParam(":idUsuario", $dataUsuarioPersonal["idUsuario"], PDO::PARAM_INT);
    $statement->bindParam(":idTipoUsuario", $dataUsuarioPersonal["idTipoUsuario"], PDO::PARAM_INT);
    $statement->bindParam(":correoUsuario", $dataUsuarioPersonal["correoUsuario"], PDO::PARAM_STR);
    $statement->bindParam(":nombreUsuario", $dataUsuarioPersonal["nombreUsuario"], PDO::PARAM_STR);
    $statement->bindParam(":apellidoUsuario", $dataUsuarioPersonal["apellidoUsuario"], PDO::PARAM_STR);
    $statement->bindParam(":fechaCreacion", $dataUsuarioPersonal["fechaCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":fechaActualizacion", $dataUsuarioPersonal["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioCreacion", $dataUsuarioPersonal["usuarioCreacion"], PDO::PARAM_INT);
    $statement->bindParam(":usuarioActualizacion", $dataUsuarioPersonal["usuarioActualizacion"], PDO::PARAM_INT);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

}
