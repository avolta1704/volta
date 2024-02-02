<?php
require_once "connection.php";
class ModelUsuarios
{
  //  Obtener datos de inicio de sesión
  public static function mdlObtenerDatosSesion($tabla, $email)
  {
    $statement = Connection::conn()->prepare("SELECT usuario.idUsuario, usuario.correoUsuario, usuario.nombreUsuario, usuario.apellidoUsuario, usuario.idTipoUsuario FROM $tabla WHERE correoUsuario=:correoUsuario");
    $statement->bindParam(":correoUsuario", $email, PDO::PARAM_STR);
    $statement->execute();
    return $statement->fetch();
  }

  //  Hacer update del last login
  public static function mdlActualizarSesion($tabla, $ultimaConexion, $idUsuario)
  {
    $statement = Connection::conn()->prepare("UPDATE $tabla SET ultimaConexion=:ultimaConexion WHERE usuario.idUsuario = $idUsuario");
    $statement->bindParam(":ultimaConexion", $ultimaConexion, PDO::PARAM_STR);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  // Obtener datos usuarios verificar
  public static function mdlObtenerDataUsuario($tabla, $email)
  {
    $statement = Connection::conn()->prepare("SELECT usuario.password FROM $tabla WHERE correoUsuario=:correoUsuario");
    $statement->bindParam(":correoUsuario", $email, PDO::PARAM_STR);
    $statement->execute();
    return $statement->fetch();
  }

  //  Obtener todos los usuarios
  public static function mdlGetAllUsuarios($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT usuario.idUsuario, usuario.correoUsuario, usuario.nombreUsuario, usuario.apellidoUsuario, usuario.estadoUsuario, usuario.ultimaConexion, tipo_usuario.descripcionTipoUsuario FROM $tabla INNER JOIN tipo_usuario ON usuario.idTipoUsuario = tipo_usuario.idTipoUsuario");
    $statement->execute();
    return $statement->fetchAll();
  }

  //  Obtener tipo de usuarios
  public static function mdlGetTipoUsuarios($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT tipo_usuario.idTipoUsuario, tipo_usuario.descripcionTipoUsuario FROM $tabla");
    $statement->execute();
    return $statement->fetchAll();
  }

  //  Obtener dato de un usuario
  public static function mdlGetUsuarioEditar($tabla, $codUsuario)
  {
    $statement = Connection::conn()->prepare("SELECT usuario.idTipoUsuario, usuario.correoUsuario, usuario.nombreUsuario, usuario.apellidoUsuario, usuario.dniUsuario, usuario.estadoUsuario, tipo_usuario.descripcionTipoUsuario FROM $tabla INNER JOIN tipo_usuario ON usuario.idTipoUsuario = tipo_usuario.idTipoUsuario WHERE usuario.idUsuario=$codUsuario");
    $statement->execute();
    return $statement->fetch();
  }

  //  Crear un nuevo usuario
  public static function mdlCrearUsuarioPersonal($tabla, $dataUsuario)
  {
    $statement = Connection::conn()->prepare("INSERT INTO $tabla (correoUsuario, password, nombreUsuario, apellidoUsuario, dniUsuario, idTipoUsuario, estadoUsuario, fechaCreacion, fechaActualizacion) VALUES(:correoUsuario, :password, :nombreUsuario, :apellidoUsuario, :dniUsuario, :idTipoUsuario, :estadoUsuario, :fechaCreacion, :fechaActualizacion)");
    $statement->bindParam(":correoUsuario", $dataUsuario["correoUsuario"], PDO::PARAM_STR);
    $statement->bindParam(":password", $dataUsuario["password"], PDO::PARAM_STR);
    $statement->bindParam(":nombreUsuario", $dataUsuario["nombreUsuario"], PDO::PARAM_STR);
    $statement->bindParam(":apellidoUsuario", $dataUsuario["apellidoUsuario"], PDO::PARAM_STR);
    $statement->bindParam(":dniUsuario", $dataUsuario["dniUsuario"], PDO::PARAM_STR);
    $statement->bindParam(":idTipoUsuario", $dataUsuario["idTipoUsuario"], PDO::PARAM_STR);
    $statement->bindParam(":estadoUsuario", $dataUsuario["estadoUsuario"], PDO::PARAM_STR);
    $statement->bindParam(":fechaCreacion", $dataUsuario["fechaCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":fechaActualizacion", $dataUsuario["fechaActualizacion"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  //  Editar data usuario personal
  public static function mdlEditarUsuarioPersonal($tabla, $dataUsuario)
  {
    $statement = Connection::conn()->prepare("UPDATE $tabla SET correoUsuario=:correoUsuario, nombreUsuario=:nombreUsuario, apellidoUsuario=:apellidoUsuario, dniUsuario=:dniUsuario, idTipoUsuario=:idTipoUsuario, fechaActualizacion=:fechaActualizacion WHERE idUsuario=:idUsuario");
    $statement->bindParam(":correoUsuario", $dataUsuario["correoUsuario"], PDO::PARAM_STR);
    $statement->bindParam(":nombreUsuario", $dataUsuario["nombreUsuario"], PDO::PARAM_STR);
    $statement->bindParam(":apellidoUsuario", $dataUsuario["apellidoUsuario"], PDO::PARAM_STR);
    $statement->bindParam(":dniUsuario", $dataUsuario["dniUsuario"], PDO::PARAM_STR);
    $statement->bindParam(":idTipoUsuario", $dataUsuario["idTipoUsuario"], PDO::PARAM_STR);
    $statement->bindParam(":fechaActualizacion", $dataUsuario["LastConnection"], PDO::PARAM_STR);
    $statement->bindParam(":idUsuario", $dataUsuario["idUsuario"], PDO::PARAM_STR);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  //  Obtener estado del usuario
  public static function mdlObtenerEstadoUsuario($tabla, $codUsuario)
  {
    $statement = Connection::conn()->prepare("SELECT estadoUsuario FROM $tabla WHERE idUsuario = $codUsuario");
    $statement->execute();
    return $statement->fetch();
  }

  //  Actualizar estado del usuario
  public static function mdlActualizarEstado($tabla, $codUsuario, $estado)
  {
    $statement = Connection::conn()->prepare("UPDATE $tabla SET estadoUsuario=:estadoUsuario WHERE idUsuario=:idUsuario");
    $statement->bindParam(":idUsuario", $codUsuario, PDO::PARAM_STR);
    $statement->bindParam(":estadoUsuario", $estado, PDO::PARAM_STR);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
}
