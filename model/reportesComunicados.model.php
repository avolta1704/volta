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
}
