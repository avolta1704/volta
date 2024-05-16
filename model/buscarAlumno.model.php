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
    alumno.estadoAlumno, 
    alumno.codAlumnoCaja, 
    alumno.dniAlumno, 
    alumno.estadoSiagie, 
    alumno.estadoMatricula, 
    alumno.fechaNacimiento, 
    alumno.direccionAlumno, 
    alumno.distritoAlumno, 
    alumno.IEPProcedencia, 
    alumno.seguroSalud, 
    alumno.fechaIngresoVolta, 
    alumno.numeroEmergencia, 
    alumno.enfermedades,
    grado.idGrado,
    grado.descripcionGrado,
    nivel.idNivel,
    nivel.descripcionNivel, 
    alumno_grado.estadoGradoAlumno,
    apoderado1.nombreApoderado as nombreApoderado1,
    apoderado1.apellidoApoderado as apellidoApoderado1,
    apoderado1.celularApoderado as celularApoderado1,
    apoderado2.nombreApoderado as nombreApoderado2,
    apoderado2.apellidoApoderado as apellidoApoderado2,
    apoderado2.celularApoderado as celularApoderado2,
    detalle_comunicacion_pago.tituloComunicacion,
    detalle_comunicacion_pago.detalleComunicacion,
    detalle_comunicacion_pago.fechaComunicacion,
    cronograma_pago.montoPago,
    cronograma_pago.mesPago,
    cronograma_pago.fechaLimite,
    CASE 
      WHEN cronograma_pago.estadoCronograma = 1 THEN 'Pendiente'
      WHEN cronograma_pago.estadoCronograma = 2 THEN 'Cancelado'
      WHEN cronograma_pago.estadoCronograma = 3 THEN 'Anulado'
      ELSE cronograma_pago.estadoCronograma
    END as estadoCronograma
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
    (SELECT * FROM apoderado_alumno LIMIT 2) as apoderado_alumno
  ON 
    alumno.idAlumno = apoderado_alumno.idAlumno
  LEFT JOIN
    apoderado as apoderado1
  ON 
    apoderado_alumno.idApoderado = apoderado1.idApoderado
  LEFT JOIN
    apoderado as apoderado2
  ON 
    apoderado_alumno.idApoderado = apoderado2.idApoderado
  LEFT JOIN
    admision_alumno
  ON 
    alumno.idAlumno = admision_alumno.idAlumno
  LEFT JOIN
    cronograma_pago
  ON 
    admision_alumno.idAdmisionAlumno = cronograma_pago.idAdmisionAlumno
  LEFT JOIN
  (SELECT * 
   FROM comunicacion_pago 
   WHERE idComunicacionPago IN 
     (SELECT MAX(idComunicacionPago) 
      FROM comunicacion_pago 
      GROUP BY idCronogramaPago)) as comunicacion_pago
  ON 
  cronograma_pago.idCronogramaPago = comunicacion_pago.idCronogramaPago
  LEFT JOIN
  (SELECT * 
   FROM detalle_comunicacion_pago 
   WHERE idDetalleComunicacion IN 
     (SELECT MAX(idDetalleComunicacion) 
      FROM detalle_comunicacion_pago 
      GROUP BY idComunicacionPago)) as detalle_comunicacion_pago
  ON 
  comunicacion_pago.idComunicacionPago = detalle_comunicacion_pago.idComunicacionPago
  WHERE 
  alumno_grado.estadoGradoAlumno = 1
  ORDER BY 
  alumno.idAlumno DESC, cronograma_pago.idCronogramaPago ASC
    ");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
}
