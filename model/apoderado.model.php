<?php
require_once "connection.php";

class ModelApoderados
{
  //mostar todos los Apoderados DataTable
  public static function mdlGetAllApoderados($table)
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
  //  Crear Apoderado apartir de un usuario
  public static function mdlCrearUsuarioApoderado($table, $dataUsuarioApoderado)
  {
    $statement = Connection::conn()->prepare("INSERT INTO $table (idUsuario, tipoApoderado, correoApoderado, nombreApoderado, apellidoApoderado, fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion)
     VALUES(:idUsuario, :idTipoUsuario, :correoUsuario, :nombreUsuario, :apellidoUsuario, :fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion)");

    $statement->bindParam(":idUsuario", $dataUsuarioApoderado["idUsuario"], PDO::PARAM_INT);
    $statement->bindParam(":idTipoUsuario", $dataUsuarioApoderado["idTipoUsuario"], PDO::PARAM_INT);
    $statement->bindParam(":correoUsuario", $dataUsuarioApoderado["correoUsuario"], PDO::PARAM_STR);
    $statement->bindParam(":nombreUsuario", $dataUsuarioApoderado["nombreUsuario"], PDO::PARAM_STR);
    $statement->bindParam(":apellidoUsuario", $dataUsuarioApoderado["apellidoUsuario"], PDO::PARAM_STR);
    $statement->bindParam(":fechaCreacion", $dataUsuarioApoderado["fechaCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":fechaActualizacion", $dataUsuarioApoderado["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioCreacion", $dataUsuarioApoderado["usuarioCreacion"], PDO::PARAM_INT);
    $statement->bindParam(":usuarioActualizacion", $dataUsuarioApoderado["usuarioActualizacion"], PDO::PARAM_INT);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  // Obtener todos los alumnos
  public static function mdlCrearApoderadoAlumno($tabla, $dataApoderado)
  {
    $statement = Connection::conn()->prepare("INSERT INTO $tabla (numeroApoderado, tipoApoderado, correoApoderado, nombreApoderado, apellidoApoderado, fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion) VALUES(:numeroApoderado, :tipoApoderado, :correoApoderado, :nombreApoderado, :apellidoApoderado, :fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion)");
    $statement->bindParam(":numeroApoderado", $dataApoderado["numeroApoderado"], PDO::PARAM_STR);
    $statement->bindParam(":tipoApoderado", $dataApoderado["tipoApoderado"], PDO::PARAM_STR);
    $statement->bindParam(":correoApoderado", $dataApoderado["correoApoderado"], PDO::PARAM_STR);
    $statement->bindParam(":nombreApoderado", $dataApoderado["nombreApoderado"], PDO::PARAM_STR);
    $statement->bindParam(":apellidoApoderado", $dataApoderado["apellidoApoderado"], PDO::PARAM_STR);
    $statement->bindParam(":fechaCreacion", $dataApoderado["fechaCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":fechaActualizacion", $dataApoderado["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioCreacion", $dataApoderado["usuarioCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioActualizacion", $dataApoderado["usuarioActualizacion"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  //  Ultimo apoderado creado
  public static function mdlObtenerUltimoApoderado($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT MAX(idApoderado) AS idApoderado FROM $tabla");
    $statement->execute();
    return $statement->fetch();
  }
  //  Obtener datos del Apoderado para editar
  public static function mdlGetIdEditApoderado($tabla, $codApoderado)
  {
    $statement = Connection::conn()->prepare("SELECT 
    idApoderado,
    nombreApoderado,
    apellidoApoderado,
    numeroApoderado,
    correoApoderado,
    listaAlumnos,
    convivenciaAlumno,
    tipoApoderado
    FROM 
    $tabla
    WHERE 
    idApoderado = :idApoderado");
    $statement->bindParam(":idApoderado", $codApoderado, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }
  //  Editar postulante
  public static function mdlIdEditarApoderado($tabla, $dataEditApoderado)
  {
    $statement = Connection::conn()->prepare("UPDATE $tabla SET nombreApoderado = :nombreApoderado, apellidoApoderado = :apellidoApoderado, numeroApoderado = :numeroApoderado, listaAlumnos = :listaAlumnos, convivenciaAlumno = :convivenciaAlumno, tipoApoderado = :tipoApoderado, fechaActualizacion = :fechaActualizacion, usuarioActualizacion = :usuarioActualizacion WHERE idApoderado = :idApoderado");
    $statement->bindParam(":nombreApoderado", $dataEditApoderado["nombreApoderado"], PDO::PARAM_STR);
    $statement->bindParam(":apellidoApoderado", $dataEditApoderado["apellidoApoderado"], PDO::PARAM_STR);
    $statement->bindParam(":numeroApoderado", $dataEditApoderado["numeroApoderado"], PDO::PARAM_STR);
    $statement->bindParam(":listaAlumnos", $dataEditApoderado["listaAlumnos"], PDO::PARAM_STR);
    $statement->bindParam(":convivenciaAlumno", $dataEditApoderado["convivenciaAlumno"], PDO::PARAM_STR);
    $statement->bindParam(":tipoApoderado", $dataEditApoderado["tipoApoderado"], PDO::PARAM_STR);
    $statement->bindParam(":fechaActualizacion", $dataEditApoderado["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioActualizacion", $dataEditApoderado["usuarioActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":idApoderado", $dataEditApoderado["idApoderado"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

}
