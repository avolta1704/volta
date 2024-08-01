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
  // obtener id del usuario para editar al personal
  public static function mdlObtenerIdUsuario($table, $codPersonal)
  {
    $statement = Connection::conn()->prepare("SELECT idUsuario FROM $table WHERE idPersonal = :idPersonal");
    $statement->bindParam(":idPersonal", $codPersonal, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }
  //  Actualizar datos del personal
  public static function mdlActualizarDatosPersonal($tabla, $dataUsuarioPersonal)
  {
    $statement = Connection::conn()->prepare("UPDATE $tabla SET nombrePersonal = :nombrePersonal, apellidoPersonal = :apellidoPersonal, correoPersonal = :correoPersonal, idTipoPersonal = :idTipoPersonal, fechaActualizacion = :fechaActualizacion, usuarioActualizacion = :usuarioActualizacion WHERE idUsuario = :idUsuario");
    $statement->bindParam(":nombrePersonal", $dataUsuarioPersonal["nombrePersonal"], PDO::PARAM_STR);
    $statement->bindParam(":apellidoPersonal", $dataUsuarioPersonal["apellidoPersonal"], PDO::PARAM_STR);
    $statement->bindParam(":correoPersonal", $dataUsuarioPersonal["correoPersonal"], PDO::PARAM_STR);
    $statement->bindParam(":fechaActualizacion", $dataUsuarioPersonal["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioActualizacion", $dataUsuarioPersonal["usuarioActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":idTipoPersonal", $dataUsuarioPersonal["idTipoPersonal"], PDO::PARAM_STR);
    $statement->bindParam(":idUsuario", $dataUsuarioPersonal["idUsuario"], PDO::PARAM_STR);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  /**
   * Editar el personal creado apartir de un usuario 
   * 
   * @param string $table
   * @param array $dataPersonal
   * @return string
   */
  public static function mdlEditarUsuarioPersonal($table, $dataPersonal)
  {
    $statement = Connection::conn()->prepare("UPDATE $table SET idTipoPersonal = :idTipoPersonal, correoPersonal = :correoPersonal, nombrePersonal = :nombrePersonal, apellidoPersonal = :apellidoPersonal, fechaActualizacion = :fechaActualizacion, usuarioActualizacion = :usuarioActualizacion WHERE idUsuario = :idUsuario");
    $statement->bindParam(":idTipoPersonal", $dataPersonal["idTipoPersonal"], PDO::PARAM_INT);
    $statement->bindParam(":correoPersonal", $dataPersonal["correoPersonal"], PDO::PARAM_STR);
    $statement->bindParam(":nombrePersonal", $dataPersonal["nombrePersonal"], PDO::PARAM_STR);
    $statement->bindParam(":apellidoPersonal", $dataPersonal["apellidoPersonal"], PDO::PARAM_STR);
    $statement->bindParam(":fechaActualizacion", $dataPersonal["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioActualizacion", $dataPersonal["usuarioActualizacion"], PDO::PARAM_INT);
    $statement->bindParam(":idUsuario", $dataPersonal["idUsuario"], PDO::PARAM_INT);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  /**
   * Crear el personal apartir de un usuario
   * 
   * @param string $table
   * @param array $dataUsuarioPersonal
   * @return string 
   */
  public static function mdlCrearUsuarioPersonalApartirUsuario($table, $dataUsuarioPersonal)
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

  //  Obtener personal por id de usuario
  public static function mdlGetPersonalByIdUsuario($tabla, $idUsuario)
  {
    $statement = Connection::conn()->prepare("SELECT * FROM $tabla WHERE idUsuario = :idUsuario");
    $statement->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }

  /**
   * Obtener el id del tipo de personal de administrativo
   * 
   * @param string $table
   * @return int $idTipoPersonal
   */

  public static function mdlObtenerIdTipoPersonal($table)
  {
    $statement = Connection::conn()->prepare("SELECT idTipoPersonal FROM $table WHERE descripcionTipo = 'Administrativo'");
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }

  /**
   * Obtener el id del tipo de personal de docente
   * 
   * @param string $table
   * @return int $idTipoPersonal
   */

  public static function mdlObtenerIdTipoDocente($table)
  {
    $statement = Connection::conn()->prepare("SELECT idTipoPersonal FROM $table WHERE descripcionTipo = 'Docente General'");
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }

  /**
   * Obtener el id del personal en base al id del usuario
   * 
   * @param string $table
   * @return int $idPersonal
   */
  public static function mdlObtenerPersonal($table, $codUsuario)
  {
    $statement = Connection::conn()->prepare("SELECT idPersonal FROM $table WHERE idUsuario = :idUsuario");
    $statement->bindParam(":idUsuario", $codUsuario, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_COLUMN);
  }

  /**
   * Eliminar personal
   * 
   * @param string $table
   * @param int $codPersonal
   */
  public static function mdlEliminarPersonal($table, $codPersonal)
  {
    $statement = Connection::conn()->prepare("DELETE FROM $table WHERE idPersonal = :idPersonal");
    $statement->bindParam(":idPersonal", $codPersonal, PDO::PARAM_INT);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
}
