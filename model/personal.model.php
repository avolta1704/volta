<?php
require_once "connection.php";
class ModelPersonal
{
 

  public static function mdlUltimoUsuarioCreado($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT usuario.idUsuario, usuario.correoUsuario, usuario.nombreUsuario, usuario.apellidoUsuario, usuario.estadoUsuario, usuario.ultimaConexion, tipo_usuario.descripcionTipoUsuario FROM $tabla INNER JOIN tipo_usuario ON usuario.idTipoUsuario = tipo_usuario.idTipoUsuario ORDER BY usuario.idUsuario DESC LIMIT 1");
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }


  public static function mdlCrearUsuarioPersonal($tabla, $dataUsuario)
  {
    $statement = Connection::conn()->prepare("INSERT INTO $tabla (idUsuario, idTipoPersonal, celularPersonal, fechaContratacion, correoPersonal, nombrePersonal, apellidoPersonal, fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion)
     VALUES(:idUsuario, tipoUsuario, NULL, NULL, :correoUsuario, :nombreUsuario, :apellidoUsuario, :fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion)");

    $statement->bindParam(":idUsuario", $dataUsuario["idUsuario"], PDO::PARAM_INT);
    $statement->bindParam(":tipoUsuario", $dataUsuario["tipoUsuario"], PDO::PARAM_INT);
    $statement->bindParam(":correoUsuario", $dataUsuario["correoUsuario"], PDO::PARAM_STR);
    $statement->bindParam(":nombreUsuario", $dataUsuario["nombreUsuario"], PDO::PARAM_STR);
    $statement->bindParam(":apellidoUsuario", $dataUsuario["apellidoUsuario"], PDO::PARAM_STR);
    $statement->bindParam(":fechaCreacion", $dataUsuario["fechaCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":fechaActualizacion", $dataUsuario["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioCreacion", $dataUsuario["usuarioCreacion"], PDO::PARAM_INT);
    $statement->bindParam(":usuarioActualizacion", $dataUsuario["usuarioActualizacion"], PDO::PARAM_INT);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

}
