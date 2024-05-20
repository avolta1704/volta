<?php
require_once "connection.php";

class ModelReportesComunicados
{
  /**
   * Obtiene todos los alumnos con comunicados de la tabla especificada.
   *
   * @param string $table Nombre de la tabla.
   * @return array Retorna un array con los datos de los alumnos con comunicados.
   */
  public static function mdlGetAllAlumnosConComunicados($table)
  {
    $tablaCronogramaPago = 'cronograma_pago';
    $tablaAdmisionAlumno = 'admision_alumno';
    $tablaAlumno = 'alumno';
    $tablaAlumnoGrado = 'alumno_grado';
    $tablaGrado = 'grado';
    $tablaNivel = 'nivel';

    $stmt = Connection::conn()->prepare(
      "SELECT a.nombresAlumno, a.apellidosAlumno, a.dniAlumno, g.descripcionGrado, n.descripcionNivel, cp.idComunicacionPago, a.idAlumno, aa.idAdmisionAlumno
          FROM $table cp
          INNER JOIN $tablaCronogramaPago cpago ON cp.idCronogramaPago = cpago.idCronogramaPago
          INNER JOIN $tablaAdmisionAlumno aa ON cpago.idAdmisionAlumno = aa.idAdmisionAlumno
          INNER JOIN $tablaAlumno a ON aa.idAlumno = a.idAlumno    
          INNER JOIN $tablaAlumnoGrado ag ON a.idAlumno = ag.idAlumno
          INNER JOIN $tablaGrado g ON ag.idGrado = g.idGrado
          INNER JOIN $tablaNivel n ON g.idNivel = n.idNivel
          "
    );

    $stmt->execute();
    return $stmt->fetchAll();
  }

  /**
   * Obtiene los comunicados por alumno desde la tabla especificada.
   *
   * @param string $table Nombre de la tabla.
   * @return array Arreglo con los comunicados por alumno.
   */
  public static function mdlGetComunicadosPorAlumno($table)
  {
    $tablaCronogramaPago = 'cronograma_pago';
    $tablaAdmisionAlumno = 'admision_alumno';
    $tablaAlumno = 'alumno';
    $tablaAlumnoGrado = 'alumno_grado';
    $tablaGrado = 'grado';
    $tablaNivel = 'nivel';
    $detalleComunicacionPago = 'detalle_comunicacion_pago';

    $stmt = Connection::conn()->prepare(
      "SELECT a.nombresAlumno, a.apellidosAlumno, a.dniAlumno, g.descripcionGrado, n.descripcionNivel, cp.idComunicacionPago, a.idAlumno, aa.idAdmisionAlumno, cpago.montoPago, cpago.mesPago, dcp.tituloComunicacion, dcp.detalleComunicacion, dcp.fechaComunicacion, aa.idAdmisionAlumno
          FROM $table cp
          INNER JOIN $tablaCronogramaPago cpago ON cp.idCronogramaPago = cpago.idCronogramaPago
          INNER JOIN $tablaAdmisionAlumno aa ON cpago.idAdmisionAlumno = aa.idAdmisionAlumno
          INNER JOIN $tablaAlumno a ON aa.idAlumno = a.idAlumno    
          INNER JOIN $tablaAlumnoGrado ag ON a.idAlumno = ag.idAlumno
          INNER JOIN $tablaGrado g ON ag.idGrado = g.idGrado
          INNER JOIN $tablaNivel n ON g.idNivel = n.idNivel
          INNER JOIN $detalleComunicacionPago dcp ON cp.idComunicacionPago = dcp.idComunicacionPago
          "
    );

    $stmt->execute();
    return $stmt->fetchAll();
  }

  /**
   * Obtiene la pensión de un alumno.
   *
   * @param int $idAdmisionAlumno El ID de admisión del alumno.
   * @return mixed La pensión del alumno.
   */
  public static function mdlGetPensionAlumno($idAdmisionAlumno)
  {
    $tablaCronogramaPago = 'cronograma_pago';
    $stmt = Connection::conn()->prepare(
      "SELECT montoPago
          FROM $tablaCronogramaPago
          WHERE idAdmisionAlumno = :idAdmisionAlumno AND mesPago != 'Matricula'
          ORDER BY idCronogramaPago ASC
          LIMIT 1"
    );

    $stmt->bindParam(':idAdmisionAlumno', $idAdmisionAlumno, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll()[0];
  }
}
