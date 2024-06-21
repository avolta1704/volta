<?php
require_once "connection.php";

class ModelApoderados
{
  //mostar todos los Apoderados DataTable
  public static function mdlGetAllApoderados($table)
  {
    $statement = Connection::conn()->prepare("SELECT nombreApoderado, apellidoApoderado, tipoApoderado, celularApoderado, correoApoderado, convivenciaAlumno, idApoderado, dniApoderado,cuentaCreada  FROM $table ORDER BY apoderado.idApoderado DESC");
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
  public static function mdlCrearApoderado($tabla, $dataApoderado)
  {
    $statement = Connection::conn()->prepare("INSERT INTO $tabla (nombreApoderado, apellidoApoderado, dniApoderado, fechaNacimiento, convivenciaAlumno, tipoApoderado, gradoInstruccion, profesionApoderado, correoApoderado, celularApoderado, dependenciaApoderado, centroLaboral, telefonoTrabajo, ingresoMensual, fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion, cuentaCreada) VALUES(:nombreApoderado, :apellidoApoderado, :dniApoderado, :fechaNacimiento, :convivenciaAlumno, :tipoApoderado, :gradoInstruccion, :profesionApoderado, :correoApoderado, :celularApoderado, :dependenciaApoderado, :centroLaboral, :telefonoTrabajo, :ingresoMensual, :fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion,:cuentaCreada)");
    $statement->bindParam(":nombreApoderado", $dataApoderado["nombreApoderado"], PDO::PARAM_STR);
    $statement->bindParam(":apellidoApoderado", $dataApoderado["apellidoApoderado"], PDO::PARAM_STR);
    $statement->bindParam(":dniApoderado", $dataApoderado["dniApoderado"], PDO::PARAM_STR);
    $statement->bindParam(":fechaNacimiento", $dataApoderado["fechaNacimiento"], PDO::PARAM_STR);
    $statement->bindParam(":convivenciaAlumno", $dataApoderado["convivenciaAlumno"], PDO::PARAM_STR);
    $statement->bindParam(":tipoApoderado", $dataApoderado["tipoApoderado"], PDO::PARAM_STR);
    $statement->bindParam(":gradoInstruccion", $dataApoderado["gradoInstruccion"], PDO::PARAM_STR);
    $statement->bindParam(":profesionApoderado", $dataApoderado["profesionApoderado"], PDO::PARAM_STR);
    $statement->bindParam(":correoApoderado", $dataApoderado["correoApoderado"], PDO::PARAM_STR);
    $statement->bindParam(":celularApoderado", $dataApoderado["celularApoderado"], PDO::PARAM_STR);
    $statement->bindParam(":dependenciaApoderado", $dataApoderado["dependenciaApoderado"], PDO::PARAM_STR);
    $statement->bindParam(":centroLaboral", $dataApoderado["centroLaboral"], PDO::PARAM_STR);
    $statement->bindParam(":telefonoTrabajo", $dataApoderado["telefonoTrabajo"], PDO::PARAM_STR);
    $statement->bindParam(":ingresoMensual", $dataApoderado["ingresoMensual"], PDO::PARAM_STR);
    $statement->bindParam(":fechaCreacion", $dataApoderado["fechaCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":fechaActualizacion", $dataApoderado["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioCreacion", $dataApoderado["usuarioCreacion"], PDO::PARAM_INT);
    $statement->bindParam(":usuarioActualizacion", $dataApoderado["usuarioActualizacion"], PDO::PARAM_INT);
    $statement->bindParam(":cuentaCreada", $dataApoderado["cuentaCreada"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  //  Editar datos de un apoderado
  public static function mdlEditarApoderado($tabla, $dataApoderado)
  {
    $statement = Connection::conn()->prepare("UPDATE $tabla SET nombreApoderado = :nombreApoderado, apellidoApoderado = :apellidoApoderado, dniApoderado = :dniApoderado, fechaNacimiento = :fechaNacimiento, convivenciaAlumno = :convivenciaAlumno, gradoInstruccion = :gradoInstruccion, profesionApoderado = :profesionApoderado, correoApoderado = :correoApoderado, celularApoderado = :celularApoderado, dependenciaApoderado = :dependenciaApoderado, centroLaboral = :centroLaboral, telefonoTrabajo = :telefonoTrabajo, ingresoMensual = :ingresoMensual, fechaActualizacion = :fechaActualizacion, usuarioActualizacion = :usuarioActualizacion WHERE idApoderado = :idApoderado");
    $statement->bindParam(":nombreApoderado", $dataApoderado["nombreApoderado"], PDO::PARAM_STR);
    $statement->bindParam(":apellidoApoderado", $dataApoderado["apellidoApoderado"], PDO::PARAM_STR);
    $statement->bindParam(":dniApoderado", $dataApoderado["dniApoderado"], PDO::PARAM_STR);
    $statement->bindParam(":fechaNacimiento", $dataApoderado["fechaNacimiento"], PDO::PARAM_STR);
    $statement->bindParam(":convivenciaAlumno", $dataApoderado["convivenciaAlumno"], PDO::PARAM_STR);
    $statement->bindParam(":gradoInstruccion", $dataApoderado["gradoInstruccion"], PDO::PARAM_STR);
    $statement->bindParam(":profesionApoderado", $dataApoderado["profesionApoderado"], PDO::PARAM_STR);
    $statement->bindParam(":correoApoderado", $dataApoderado["correoApoderado"], PDO::PARAM_STR);
    $statement->bindParam(":celularApoderado", $dataApoderado["celularApoderado"], PDO::PARAM_STR);
    $statement->bindParam(":dependenciaApoderado", $dataApoderado["dependenciaApoderado"], PDO::PARAM_STR);
    $statement->bindParam(":centroLaboral", $dataApoderado["centroLaboral"], PDO::PARAM_STR);
    $statement->bindParam(":telefonoTrabajo", $dataApoderado["telefonoTrabajo"], PDO::PARAM_STR);
    $statement->bindParam(":ingresoMensual", $dataApoderado["ingresoMensual"], PDO::PARAM_STR);
    $statement->bindParam(":fechaActualizacion", $dataApoderado["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioActualizacion", $dataApoderado["usuarioActualizacion"], PDO::PARAM_INT);
    $statement->bindParam(":idApoderado", $dataApoderado["idApoderado"], PDO::PARAM_INT);
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
    return $statement->fetch(PDO::FETCH_ASSOC);
  }
  //  Obtener datos del Apoderado para editar
  public static function mdlGetIdEditApoderado($tabla, $codApoderado)
  {
    $statement = Connection::conn()->prepare("SELECT 
    idApoderado,
    nombreApoderado,
    apellidoApoderado,
    correoApoderado,
    celularApoderado,
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
  //  Editar Apoderado
  public static function mdlIdEditarApoderado($tabla, $dataEditApoderado)
  {
    $statement = Connection::conn()->prepare("UPDATE $tabla SET nombreApoderado = :nombreApoderado, apellidoApoderado = :apellidoApoderado, celularApoderado = :celularApoderado, listaAlumnos = :listaAlumnos, convivenciaAlumno = :convivenciaAlumno, tipoApoderado = :tipoApoderado, fechaActualizacion = :fechaActualizacion, usuarioActualizacion = :usuarioActualizacion WHERE idApoderado = :idApoderado");
    $statement->bindParam(":nombreApoderado", $dataEditApoderado["nombreApoderado"], PDO::PARAM_STR);
    $statement->bindParam(":apellidoApoderado", $dataEditApoderado["apellidoApoderado"], PDO::PARAM_STR);
    $statement->bindParam(":celularApoderado", $dataEditApoderado["celularApoderado"], PDO::PARAM_STR);
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

  //  Get apoderado by id
  public static function mdlGetApoderadoById($table, $codApoderado)
  {
    $statement = Connection::conn()->prepare("SELECT
    apoderado.idApoderado, 
    apoderado.nombreApoderado, 
    apoderado.apellidoApoderado, 
    apoderado.dniApoderado, 
    apoderado.convivenciaAlumno, 
    apoderado.fechaNacimiento, 
    apoderado.tipoApoderado, 
    apoderado.correoApoderado, 
    apoderado.celularApoderado, 
    apoderado.dependenciaApoderado, 
    apoderado.centroLaboral, 
    apoderado.telefonoTrabajo, 
    apoderado.ingresoMensual, 
    apoderado.gradoInstruccion, 
    apoderado.profesionApoderado
  FROM
    $table
  WHERE
    idApoderado = :idApoderado");
    $statement->bindParam(":idApoderado", $codApoderado, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }

  /**
   * Método para obtener los datos de uno o varios apoderados.
   * 
   * @param string $tabla ID del alumno.
   * @param int $apoderado1 JSON con los datos de los apoderados.
   * @param int $apoderado2 JSON con los datos de los apoderados.
   * @return array $response Respuesta de la consulta.
   */
  public static function mdlGetDatosApoderados($tabla, $apoderado1, $apoderado2)
  {
    $statement = Connection::conn()->prepare("SELECT
	apoderado.nombreApoderado, 
	apoderado.profesionApoderado, 
	apoderado.apellidoApoderado, 
	apoderado.correoApoderado, 
	apoderado.dniApoderado, 
	apoderado.celularApoderado, 
	apoderado.fechaNacimiento, 
	apoderado.dependenciaApoderado, 
	apoderado.convivenciaAlumno, 
	apoderado.centroLaboral, 
	apoderado.gradoInstruccion, 
	apoderado.telefonoTrabajo, 
	apoderado.ingresoMensual, 
	apoderado.tipoApoderado
FROM
	$tabla
WHERE apoderado.idApoderado = :apoderado1 OR apoderado.idApoderado = :apoderado2");
    $statement->bindParam(":apoderado1", $apoderado1, PDO::PARAM_INT);
    $statement->bindParam(":apoderado2", $apoderado2, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
  public static function mdlGetAllApoderadosByAlumno($table, $idAlumno)
  {
    $statement = Connection::conn()->prepare("SELECT
      apoderado.nombreApoderado, 
      apoderado.apellidoApoderado, 
      apoderado.celularApoderado, 
      apoderado.dniApoderado, 
      apoderado.convivenciaAlumno, 
      apoderado.correoApoderado
    FROM
      apoderado
      INNER JOIN
      apoderado_alumno
      ON 
        apoderado.idApoderado = apoderado_alumno.idApoderado
      INNER JOIN
      alumno
      ON 
        apoderado_alumno.idAlumno = alumno.idAlumno
    WHERE
      alumno.idAlumno = :idAlumno");
    $statement->bindParam(":idAlumno", $idAlumno, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
  //Obtener el otro id del apoderado
  public static function mdlObtenerIdSegundoIdApoderado($idApoderado){
    $statement = Connection::conn()->prepare("SELECT DISTINCT
    a2.idApoderado
    FROM
        apoderado
    INNER JOIN
        apoderado_alumno ON apoderado.idApoderado = apoderado_alumno.idApoderado
    INNER JOIN
        alumno ON apoderado_alumno.idAlumno = alumno.idAlumno
    INNER JOIN
        apoderado_alumno aa2 ON alumno.idAlumno = aa2.idAlumno
    INNER JOIN
        apoderado a2 ON aa2.idApoderado = a2.idApoderado
    WHERE
        apoderado.idApoderado = :idApoderado AND a2.idApoderado != :idApoderado");
    $statement->bindParam(":idApoderado", $idApoderado, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }
  // Cambiar el estado de cuenta creada
  public static function mdlCambiarEstadoCuentaCreada($tabla,$cuentaCreada, $idApoderado1,$idApoderado2){
    $statement = Connection::conn()->prepare("UPDATE $tabla SET cuentaCreada = :cuentaCreada WHERE idApoderado IN (:idApoderado1, :idApoderado2);");
    $statement->bindParam(":idApoderado1", $idApoderado1, PDO::PARAM_INT);
    $statement->bindParam(":idApoderado2", $idApoderado2, PDO::PARAM_INT);
    $statement->bindParam(":cuentaCreada", $cuentaCreada, PDO::PARAM_INT);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
    // Cambiar el estado de cuenta creada con eliminacion del idUsuario
    public static function mdlCambiarEstadoCuentaCreadaIdUsuario($tabla,$cuentaCreada, $idApoderado1,$idApoderado2){
      $statement = Connection::conn()->prepare("UPDATE $tabla SET cuentaCreada = :cuentaCreada, idUsuario = NULL WHERE idApoderado IN (:idApoderado1, :idApoderado2)");
      $statement->bindParam(":idApoderado1", $idApoderado1, PDO::PARAM_INT);
      $statement->bindParam(":idApoderado2", $idApoderado2, PDO::PARAM_INT);
      $statement->bindParam(":cuentaCreada", $cuentaCreada, PDO::PARAM_INT);
      if ($statement->execute()) {
        return "ok";
      } else {
        return "error";
      }
    }
  public static function mdlInsertarIdUsuarioApoderado($tabla, $idUsuario, $idApoderado1,$idApoderado2){
    $statement = Connection::conn()->prepare("UPDATE $tabla SET idUsuario = :idUsuario WHERE idApoderado IN (:idApoderado1, :idApoderado2);");
    $statement->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
    $statement->bindParam(":idApoderado1", $idApoderado1, PDO::PARAM_INT);
    $statement->bindParam(":idApoderado2", $idApoderado2, PDO::PARAM_INT);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
}
