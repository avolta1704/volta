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
    $statement = Connection::conn()->prepare("INSERT INTO $table (idUsuario, idTipoPersonal, correoPersonal, nombrePersonal, apellidoPersonal, fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion) VALUES(:idUsuario, :idTipoPersonal, :correoPersonal, :nombrePersonal, :apellidoPersonal, :fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion)");

    $statement->bindParam(":idUsuario", $dataUsuarioPersonal["idUsuario"], PDO::PARAM_INT);
    $statement->bindParam(":idTipoPersonal", $dataUsuarioPersonal["idTipoPersonal"], PDO::PARAM_INT);
    $statement->bindParam(":correoPersonal", $dataUsuarioPersonal["correoPersonal"], PDO::PARAM_STR);
    $statement->bindParam(":nombrePersonal", $dataUsuarioPersonal["nombrePersonal"], PDO::PARAM_STR);
    $statement->bindParam(":apellidoPersonal", $dataUsuarioPersonal["apellidoPersonal"], PDO::PARAM_STR);
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
  //  Obtener datos del Personal para editar
  public static function mdlGetIdEditPersonal($tabla, $codPersonal)
  {
    $statement = Connection::conn()->prepare("SELECT 
      idPersonal,
      nombrePersonal,
      apellidoPersonal,
      celularPersonal,
      correoPersonal,
      fechaContratacion,
      idTipoPersonal
      FROM 
      $tabla
      WHERE 
      idPersonal = :idPersonal");
    $statement->bindParam(":idPersonal", $codPersonal, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }
  //  Editar Personal
  public static function mdlIdEditarPersonal($tabla, $dataEditPersonal)
  {
    $statement = Connection::conn()->prepare("UPDATE $tabla SET nombrePersonal = :nombrePersonal, apellidoPersonal = :apellidoPersonal, celularPersonal = :celularPersonal, fechaContratacion = :fechaContratacion, idTipoPersonal = :idTipoPersonal, fechaActualizacion = :fechaActualizacion, usuarioActualizacion = :usuarioActualizacion WHERE idPersonal = :idPersonal");
    $statement->bindParam(":nombrePersonal", $dataEditPersonal["nombrePersonal"], PDO::PARAM_STR);
    $statement->bindParam(":apellidoPersonal", $dataEditPersonal["apellidoPersonal"], PDO::PARAM_STR);
    $statement->bindParam(":celularPersonal", $dataEditPersonal["celularPersonal"], PDO::PARAM_STR);
    $statement->bindParam(":fechaContratacion", $dataEditPersonal["fechaContratacion"], PDO::PARAM_STR);
    $statement->bindParam(":idTipoPersonal", $dataEditPersonal["idTipoPersonal"], PDO::PARAM_STR);
    $statement->bindParam(":fechaActualizacion", $dataEditPersonal["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioActualizacion", $dataEditPersonal["usuarioActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":idPersonal", $dataEditPersonal["idPersonal"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  //  Obtener tipo de docente para el inicio de sesion
  public static function mdlGetTipoDocente($table, $codUsuario)
  {
    $statement = Connection::conn()->prepare("SELECT
    tipo_personal.idTipoPersonal, 
    tipo_personal.descripcionTipo
  FROM
    $table
    INNER JOIN
    tipo_personal
    ON 
      personal.idTipoPersonal = tipo_personal.idTipoPersonal
    INNER JOIN
    usuario
    ON 
      personal.idUsuario = usuario.idUsuario
  WHERE
    usuario.idUsuario = :idUsuario");
    $statement->bindParam(":idUsuario", $codUsuario, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }
}
