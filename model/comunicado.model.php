<?php
require_once "connection.php";
class ModelComunicado
{
  //  obtener los alumnos para pagoAlumnos para su comunicado de pago
  public static function mdlGetAllPagoAlumnos($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT
      alumno.idAlumno, 
      alumno.codAlumnoCaja, 
      alumno.dniAlumno,
      alumno.nombresAlumno, 
      alumno.apellidosAlumno, 
      alumno.estadoAlumno,
      admision_alumno.idAdmisionAlumno
      FROM
      $tabla
      INNER JOIN
      admision_alumno
      ON 
      alumno.idAlumno = admision_alumno.idAlumno
      WHERE alumno.estadoAlumno IN (1, 2)
      ORDER BY alumno.idAlumno DESC");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
  //datos del alumno y apoderado para el comunicado de pago
  public static function mdlGetDatosAlumnoComunicado($tabla, $codAlumno)
  {
    $statement = Connection::conn()->prepare("SELECT
    alumno.nombresAlumno, 
    alumno.apellidosAlumno, 
    alumno.sexoAlumno, 
    alumno.estadoAlumno, 
    alumno.codAlumnoCaja, 
    alumno.dniAlumno, 
    grado.descripcionGrado, 
    nivel.descripcionNivel, 
    apoderado.tipoApoderado,
    apoderado.correoApoderado,
    apoderado.nombreApoderado,
    apoderado.apellidoApoderado,
    apoderado.convivenciaAlumno
    FROM
    $tabla
    INNER JOIN
    alumno_grado
    ON 
    alumno.idAlumno = alumno_grado.idAlumno
    INNER JOIN
    grado
    ON 
    alumno_grado.idGrado = grado.idGrado
    INNER JOIN
    nivel
    ON 
    grado.idNivel = nivel.idNivel
    LEFT JOIN
    apoderado_alumno
    ON 
    alumno.idAlumno = apoderado_alumno.idAlumno
    LEFT JOIN
    apoderado
    ON 
    apoderado_alumno.idApoderado = apoderado.idApoderado
    WHERE alumno_grado.estadoGradoAlumno = 1 AND alumno.idAlumno = :idAlumno
    LIMIT 1");
    $statement->bindParam(":idAlumno", $codAlumno, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }
  //cronograma de pago para el comunicado de pago $codCronograma = idAdmisionAlumno $tabla = cronograma_pago
  public static function mdlGetCronogramaPagoComunicado($tabla, $codCronograma)
  {
    $statement = Connection::conn()->prepare("
        SELECT 
          cp.idCronogramaPago,
          cp.conceptoPago,
          cp.montoPago,
          cp.mesPago,
          cp.fechaLimite,
          cp.estadoCronograma
        FROM $tabla cp
        WHERE cp.idAdmisionAlumno = :idAdmisionAlumno
        GROUP BY cp.idCronogramaPago
      ");
    $statement->bindParam(":idAdmisionAlumno", $codCronograma, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  //comunciados asociados al cronograma de pago del alumno
  public static function mdlGetComunicadoPago($tabla, $codCronograma)
  {
    $statement = Connection::conn()->prepare("
        SELECT 
          dcp.idDetalleComunicacion,
          dcp.idComunicacionPago,
          dcp.tituloComunicacion,
          dcp.detalleComunicacion,
          dcp.fechaComunicacion
        FROM comunicacion_pago com
        LEFT JOIN detalle_comunicacion_pago dcp ON com.idComunicacionPago = dcp.idComunicacionPago
        WHERE com.idCronogramaPago = :idCronogramaPago
        ORDER BY dcp.fechaComunicacion DESC
      ");
    $statement->bindParam(":idCronogramaPago", $codCronograma, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
  // Registro de comunicado de pago
  public static function mdlCrearRegistroComunciadoPago($tabla, $dataComunicadoPago)
  {
    $statement = Connection::conn()->prepare("INSERT INTO $tabla (idCronogramaPago, fechaCreacion, usuarioCreacion) VALUES (:idCronogramaPago, :fechaCreacion, :usuarioCreacion)");
    $statement->bindParam(":idCronogramaPago", $dataComunicadoPago["idCronogramaPago"], PDO::PARAM_INT);
    $statement->bindParam(":fechaCreacion", $dataComunicadoPago["fechaCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioCreacion", $dataComunicadoPago["usuarioCreacion"], PDO::PARAM_STR);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  //obtener el ultimo id de comunicacion_pago registrado
  public static function mdlUltimoRegistroComunicacionPago($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT MAX(idComunicacionPago) as idComunicacionPago FROM $tabla");
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }
  // Registro de detalle de comunicado de pago
  public static function mdlCrearRegistroDetalleComunciado($tabla, $dataDetalleComunicado)
  {
    $statement = Connection::conn()->prepare("INSERT INTO $tabla (idComunicacionPago, tituloComunicacion, detalleComunicacion, fechaComunicacion, fechaCreacion, usuarioCreacion) VALUES (:idComunicacionPago, :tituloComunicacion, :detalleComunicacion, :fechaComunicacion, :fechaCreacion, :usuarioCreacion)");
    $statement->bindParam(":idComunicacionPago", $dataDetalleComunicado["idComunicacionPago"], PDO::PARAM_INT);
    $statement->bindParam(":tituloComunicacion", $dataDetalleComunicado["tituloComunicacion"], PDO::PARAM_STR);
    $statement->bindParam(":detalleComunicacion", $dataDetalleComunicado["detalleComunicacion"], PDO::PARAM_STR);
    $statement->bindParam(":fechaComunicacion", $dataDetalleComunicado["fechaComunicacion"], PDO::PARAM_STR);
    $statement->bindParam(":fechaCreacion", $dataDetalleComunicado["fechaCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioCreacion", $dataDetalleComunicado["usuarioCreacion"], PDO::PARAM_STR);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  // editar Registro de detalle comunicado de pago
  public static function mdlEditarRegistroDetalleComunciado($tabla, $dataEditarComunicado)
  {
    $statement = Connection::conn()->prepare("UPDATE $tabla SET tituloComunicacion = :tituloComunicacion, detalleComunicacion = :detalleComunicacion, fechaComunicacion = :fechaComunicacion, fechaActualizacion = :fechaActualizacion, usuarioActualizacion = :usuarioActualizacion WHERE idDetalleComunicacion = :idDetalleComunicacion");
    $statement->bindParam(":idDetalleComunicacion", $dataEditarComunicado["idDetalleComunicacion"], PDO::PARAM_INT);
    $statement->bindParam(":tituloComunicacion", $dataEditarComunicado["tituloComunicacion"], PDO::PARAM_STR);
    $statement->bindParam(":detalleComunicacion", $dataEditarComunicado["detalleComunicacion"], PDO::PARAM_STR);
    $statement->bindParam(":fechaComunicacion", $dataEditarComunicado["fechaComunicacion"], PDO::PARAM_STR);
    $statement->bindParam(":fechaActualizacion", $dataEditarComunicado["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioActualizacion", $dataEditarComunicado["usuarioActualizacion"], PDO::PARAM_STR);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  // borrar Registro de detalle de comunicado de pago
  public static function mdlBorrarRegistroDetalleComunciado($tabla, $codComunicadoDetalle)
  {
    $statement = Connection::conn()->prepare("DELETE FROM $tabla WHERE idDetalleComunicacion = :idDetalleComunicacion");
    $statement->bindParam(":idDetalleComunicacion", $codComunicadoDetalle, PDO::PARAM_INT);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  // Borrar Registro de comunicado de pago
  public static function mdlBorrarRegistroComunciadoPago($tabla, $codComunicado)
  {
    $statement = Connection::conn()->prepare("DELETE FROM $tabla WHERE idComunicacionPago = :idComunicacionPago");
    $statement->bindParam(":idComunicacionPago", $codComunicado, PDO::PARAM_INT);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

}
