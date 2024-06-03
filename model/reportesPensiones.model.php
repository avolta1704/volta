<?php
require_once "connection.php";

class ModelReportesPensiones
{
  /**
   * Obtiene los cronogramas de pago generales.
   *
   * @return array Retorna un arreglo con los cronogramas de pago generales.
   */
  public static function mdlGetCronogramasPagoGeneral()
  {
    $tablaCronogramaPago = 'cronograma_pago';
    $tablaAdmisionAlumno = 'admision_alumno';
    $tablaAlumno = 'alumno';
    $tablaAlumnoAnioEscolar = 'alumno_anio_escolar';
    $tablaGrado = 'grado';
    $tablaNivel = 'nivel';
    $date = date('Y-m-d');

    $stmt = Connection::conn()->prepare("SELECT cp.idCronogramaPago, cp.mesPago, cp.montoPago, cp.fechaLimite, cp.estadoCronograma, a.nombresAlumno, a.apellidosAlumno, a.dniAlumno, g.descripcionGrado, n.descripcionNivel, a.idAlumno
                                        FROM $tablaCronogramaPago cp
                                        INNER JOIN $tablaAdmisionAlumno aa ON cp.idAdmisionAlumno = aa.idAdmisionAlumno
                                        INNER JOIN $tablaAlumno a ON aa.idAlumno = a.idAlumno
                                        INNER JOIN $tablaAlumnoAnioEscolar ag a.idAlumno = ag.idAlumno
                                        INNER JOIN $tablaGrado g ON ag.idGrado = g.idGrado
                                        INNER JOIN $tablaNivel n ON g.idNivel = n.idNivel
                                        ORDER BY cp.fechaLimite ASC");

    $stmt->execute();
    return $stmt->fetchAll();
  }

  /**
   * Obtiene los cronogramas de pago pendientes.
   *
   * @return array Retorna un array con los cronogramas de pago pendientes.
   */
  public static function mdlGetCronogramasPagoPendientes()
  {
    $tablaCronogramaPago = 'cronograma_pago';
    $tablaAdmisionAlumno = 'admision_alumno';
    $tablaAlumno = 'alumno';
    $tablaAlumnoAnioEscolar = 'alumno_anio_escolar';
    $tablaGrado = 'grado';
    $tablaNivel = 'nivel';
    $date = date('Y-m-d');

    $stmt = Connection::conn()->prepare("SELECT cp.idCronogramaPago, cp.mesPago, cp.montoPago, cp.fechaLimite, cp.estadoCronograma, a.nombresAlumno, a.apellidosAlumno, a.dniAlumno, g.descripcionGrado, n.descripcionNivel, a.idAlumno, cp.idAdmisionAlumno
                                        FROM $tablaCronogramaPago cp
                                        INNER JOIN $tablaAdmisionAlumno aa ON cp.idAdmisionAlumno = aa.idAdmisionAlumno
                                        INNER JOIN $tablaAlumno a ON aa.idAlumno = a.idAlumno
                                        INNER JOIN $tablaAlumnoAnioEscolar ag ON a.idAlumno = ag.idAlumno
                                        INNER JOIN $tablaGrado g ON ag.idGrado = g.idGrado
                                        INNER JOIN $tablaNivel n ON g.idNivel = n.idNivel
                                        WHERE cp.fechaLimite < '$date' AND cp.estadoCronograma = 1 ORDER BY cp.fechaLimite ASC");

    $stmt->execute();
    return $stmt->fetchAll();
  }

  /**
   * Obtiene los cronogramas de pagos general con el estado del alumno.
   *
   * @return array Los cronogramas de pago general con el estado del alumno.
   */
  public static function mdlGetCronogramasPagoPorRango()
  {
    $tablaCronogramaPago = 'cronograma_pago';
    $tablaAdmisionAlumno = 'admision_alumno';
    $tablaAlumno = 'alumno';
    $tablaAlumnoAnioEscolar = 'alumno_anio_escolar';
    $tablaGrado = 'grado';
    $tablaNivel = 'nivel';
    $date = date('Y-m-d');

    $stmt = Connection::conn()->prepare("SELECT cp.idCronogramaPago, cp.mesPago, cp.montoPago, cp.fechaLimite, cp.estadoCronograma, a.nombresAlumno, a.apellidosAlumno, a.dniAlumno, g.descripcionGrado, n.descripcionNivel, a.idAlumno, ag.estadoAdmisionAlumno
                                        FROM $tablaCronogramaPago cp
                                        INNER JOIN $tablaAdmisionAlumno aa ON cp.idAdmisionAlumno = aa.idAdmisionAlumno
                                        INNER JOIN $tablaAlumno a ON aa.idAlumno = a.idAlumno
                                        INNER JOIN $tablaAlumnoAnioEscolar ag ON a.idAlumno = ag.idAlumno
                                        INNER JOIN $tablaGrado g ON ag.idGrado = g.idGrado
                                        INNER JOIN $tablaNivel n ON g.idNivel = n.idNivel
                                        ORDER BY cp.fechaLimite ASC");

    $stmt->execute();
    return $stmt->fetchAll();
  }
}
