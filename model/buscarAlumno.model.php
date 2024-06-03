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
    admision_alumno.estadoAdmisionAlumno,
    grado.idGrado,
    grado.descripcionGrado,
    nivel.idNivel,
    nivel.descripcionNivel, 
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
    alumno
    INNER JOIN alumno_anio_escolar ON alumno.idAlumno = alumno_anio_escolar.idAlumno
    INNER JOIN grado ON alumno_anio_escolar.idGrado = grado.idGrado
    INNER JOIN nivel ON grado.idNivel = nivel.idNivel
    LEFT JOIN apoderado_alumno ON alumno.idAlumno = apoderado_alumno.idAlumno
    LEFT JOIN apoderado as apoderado1 ON apoderado_alumno.idApoderado = apoderado1.idApoderado
    LEFT JOIN apoderado as apoderado2 ON apoderado_alumno.idApoderado = apoderado2.idApoderado
    LEFT JOIN admision_alumno ON alumno.idAlumno = admision_alumno.idAlumno
    LEFT JOIN cronograma_pago ON admision_alumno.idAdmisionAlumno = cronograma_pago.idAdmisionAlumno
    LEFT JOIN comunicacion_pago ON cronograma_pago.idCronogramaPago = comunicacion_pago.idCronogramaPago
    LEFT JOIN detalle_comunicacion_pago ON comunicacion_pago.idComunicacionPago = detalle_comunicacion_pago.idComunicacionPago
WHERE
    admision_alumno.estadoAdmisionAlumno = 2
ORDER BY 
    alumno.idAlumno DESC, 
    cronograma_pago.idCronogramaPago ASC

    ");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
}
