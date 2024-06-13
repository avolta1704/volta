<?php
require_once "connection.php";

class ModelBuscarAlumno
{
  // Obtener todos los alumnos
  public static function mdlGetAllBusquedaAlumno($tabla)
  {

    $statement = Connection::conn()->prepare("
    SELECT
    alumno.idAlumno, 
    alumno.nombresAlumno, 
    alumno.apellidosAlumno, 
    alumno.sexoAlumno, 
    alumno.codAlumnoCaja, 
    alumno.dniAlumno, 
    alumno.estadoSiagie, 
    alumno.fechaNacimiento, 
    alumno.direccionAlumno, 
    alumno.distritoAlumno, 
    alumno.IEPProcedencia, 
    alumno.seguroSalud, 
    alumno.fechaIngresoVolta, 
    alumno.numeroEmergencia, 
    alumno.enfermedades,
		alumno.nuevoAlumno,
    admision_alumno.estadoAdmisionAlumno,
    grado.idGrado,
    grado.descripcionGrado,
    nivel.idNivel,
    nivel.descripcionNivel, 
    detalle_comunicacion_pago.tituloComunicacion,
    detalle_comunicacion_pago.detalleComunicacion,
    detalle_comunicacion_pago.fechaComunicacion,
    cronograma_pago.montoPago,
    cronograma_pago.mesPago,
    cronograma_pago.fechaLimite,
		pago.numeroComprobante,
    CASE 
        WHEN cronograma_pago.estadoCronograma = 1 THEN 'Pendiente'
        WHEN cronograma_pago.estadoCronograma = 2 THEN 'Cancelado'
        WHEN cronograma_pago.estadoCronograma = 3 THEN 'Anulado'
        ELSE cronograma_pago.estadoCronograma
    END as estadoCronograma
FROM
    alumno
    INNER JOIN alumno_anio_escolar ON alumno.idAlumno = alumno_anio_escolar.idAlumno
    INNER JOIN grado ON alumno_anio_escolar.idGrado = grado.idGrado
    INNER JOIN nivel ON grado.idNivel = nivel.idNivel
    LEFT JOIN admision_alumno ON alumno.idAlumno = admision_alumno.idAlumno
    LEFT JOIN cronograma_pago ON admision_alumno.idAdmisionAlumno = cronograma_pago.idAdmisionAlumno
    LEFT JOIN comunicacion_pago ON cronograma_pago.idCronogramaPago = comunicacion_pago.idCronogramaPago
    LEFT JOIN detalle_comunicacion_pago ON comunicacion_pago.idComunicacionPago = detalle_comunicacion_pago.idComunicacionPago
		LEFT JOIN pago ON pago.idCronogramaPago = cronograma_pago.idCronogramaPago
WHERE
    admision_alumno.estadoAdmisionAlumno = 2
ORDER BY 
    alumno.idAlumno DESC, 
    cronograma_pago.idCronogramaPago ASC

    ");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
  public static function mdlGetAllPagosYCronogramaporAlumno($idAlumno)
  {
    $statement = Connection::conn()->prepare("
    SELECT
      cronograma_pago.mesPago, 
      cronograma_pago.montoPago, 
      pago.numeroComprobante
    FROM
      cronograma_pago
      LEFT JOIN
      pago
      ON 
        cronograma_pago.idCronogramaPago = pago.idCronogramaPago
      INNER JOIN
      admision_alumno
      ON 
        cronograma_pago.idAdmisionAlumno = admision_alumno.idAdmisionAlumno
      INNER JOIN
      alumno
      ON 
        admision_alumno.idAlumno = alumno.idAlumno
    WHERE
      alumno.idAlumno = :idAlumno");
    $statement->bindParam(":idAlumno", $idAlumno, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
}
