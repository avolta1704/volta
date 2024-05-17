<?php
require_once "connection.php";

class ModelReportesPensiones
{
  public static function mdlGetCronogramasPagoPendientes()
  {
    $tablaCronogramaPago = 'cronograma_pago';
    $tablaAdmisionAlumno = 'admision_alumno';
    $tablaAlumno = 'alumno';
    $tablaAlumnoGrado = 'alumno_grado';
    $tablaGrado = 'grado';
    $tablaNivel = 'nivel';
    $date = date('Y-m-d');

    $stmt = Connection::conn()->prepare("SELECT cp.idCronogramaPago, cp.mesPago, cp.montoPago, cp.fechaLimite, cp.estadoCronograma, a.nombresAlumno, a.apellidosAlumno, a.dniAlumno, g.descripcionGrado, n.descripcionNivel, a.idAlumno
                                        FROM $tablaCronogramaPago cp
                                        INNER JOIN $tablaAdmisionAlumno aa ON cp.idAdmisionAlumno = aa.idAdmisionAlumno
                                        INNER JOIN $tablaAlumno a ON aa.idAlumno = a.idAlumno
                                        INNER JOIN $tablaAlumnoGrado ag ON a.idAlumno = ag.idAlumno
                                        INNER JOIN $tablaGrado g ON ag.idGrado = g.idGrado
                                        INNER JOIN $tablaNivel n ON g.idNivel = n.idNivel
                                        WHERE cp.fechaLimite < '$date' AND cp.estadoCronograma = 1 ORDER BY cp.fechaLimite ASC");

    $stmt->execute();
    return $stmt->fetchAll();
  }
}
