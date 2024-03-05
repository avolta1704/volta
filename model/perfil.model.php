<?php
require_once "connection.php";
class ModelPerfil
{
  //  Obtener todo el perfil de usuario
  public static function mdlGetAllPerfilUsuario($table, $idUsuario)
  {
    $statement = Connection::conn()->prepare("SELECT
    tu.idTipoUsuario,
    u.nombreUsuario, 
    u.apellidoUsuario, 
    u.dniUsuario,
    u.correoUsuario, 
    u.estadoUsuario,
    u.ultimaConexion
    FROM 
    $table u
    INNER JOIN 
    tipo_usuario tu ON u.idTipoUsuario = tu.idTipoUsuario
    WHERE 
    u.idUsuario = :idUsuario");
    $statement->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }
  //  Obtener todo el perfil de usuario para mostar en editar perfil
  public static function mdlGetAllPerfilUsuarioDataEdit($table, $idUsuario)
  {
    $statement = Connection::conn()->prepare("SELECT
      u.nombreUsuario, 
      u.apellidoUsuario, 
      u.dniUsuario,
      u.correoUsuario
      FROM 
      $table u
      WHERE 
      u.idUsuario = :idUsuario");
    $statement->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }

  //  Obtener todo el perfil de personal
  public static function mdlGetAllPerfilPersonal($table, $idUsuario)
  {
    $statement = Connection::conn()->prepare("SELECT
    u.estadoUsuario,
    p.idTipoPersonal, 
    u.dniUsuario,
    p.idPersonal, 
    p.idUsuario,
    p.celularPersonal, 
    p.fechaContratacion, 
    p.correoPersonal, 
    p.nombrePersonal, 
    p.apellidoPersonal,  
    u.ultimaConexion
    FROM 
    $table p
    INNER JOIN 
      usuario u ON p.idUsuario = u.idUsuario
    WHERE 
      p.idUsuario = :idUsuario
    ");
    $statement->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }
  //  Obtener todo el perfil de personal para mostar en editar perfil
  public static function mdlGetAllPerfilPersonalDataEdit($table, $idUsuario)
  {
    $statement = Connection::conn()->prepare("SELECT
    u.dniUsuario,
    p.nombrePersonal, 
    p.apellidoPersonal,
    p.correoPersonal,
    p.celularPersonal
    FROM 
    $table p
    INNER JOIN 
      usuario u ON p.idUsuario = u.idUsuario
    WHERE 
      p.idUsuario = :idUsuario
    ");
    $statement->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }
}
