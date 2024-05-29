<?php
require_once "connection.php";

class ModelReportesAdmisiones
{
  /**
   * Obtiene el reporte de admisiones desde la base de datos.
   *
   * @param string $tabla El nombre de la tabla en la base de datos.
   * @return array El reporte de admisiones.
   */
  static public function mdlGetReporteAdmisiones($tabla)
  {
    $tablaAdmision = "admision";
    $tablaAlumno = "alumno";
    $tablaAñoEscolar = "anio_escolar";
    $tablaAñoAdmision = "anio_admision";
    $stmt = Connection::conn()->prepare("SELECT aa.idAdmisionAlumno, a.idAnioEscolar, ae.estadoAnio, aa.idAlumno, aa.estadoAdmisionAlumno, al.nombresAlumno, al.apellidosAlumno
      FROM $tabla AS aa
      INNER JOIN $tablaAdmision AS a ON aa.idAdmision = a.idAdmision
      INNER JOIN $tablaAñoAdmision AS ana ON aa.idAdmisionAlumno = ana.idAdmisionAlumno
      INNER JOIN $tablaAñoEscolar AS ae ON ana.idAnioEscolar = ae.idAnioEscolar
      INNER JOIN $tablaAlumno AS al ON aa.idAlumno = al.idAlumno
      WHERE ae.estadoAnio = 1");
    if ($stmt->execute()) {
      return $stmt->fetchAll();
    } else {
      return "error";
    }
  }

  /**
   * Obtiene el reporte de admisiones por año lectivo.
   * 
   * @param string $tabla El nombre de la tabla en la base de datos.
   * @param array $aniosLectivo Array de los años seleccionados.
   * @return array/string El reporte de admisiones por año lectivo.
   */
  static public function mdlGetReportesPorAnioLectivo($tabla, $aniosLectivo)
  {
    $tablaAdmision = "admision";
    $tablaAlumno = "alumno";
    $tablaAnioAdmision = "anio_admision";
    $tablaAnioEscolar = "anio_escolar";
    $tablaAlumnoGrado = "alumno_grado";
    $tablaGrado = "grado";
    $tablaNivel = "nivel";
    $stmt = Connection::conn()->prepare("SELECT aa.idAdmisionAlumno, a.idAnioEscolar, ae.estadoAnio, aa.idAlumno, aa.estadoAdmisionAlumno, al.nombresAlumno, al.apellidosAlumno, g.descripcionGrado, n.descripcionNivel
      FROM $tabla AS aa
      INNER JOIN $tablaAdmision AS a ON aa.idAdmision = a.idAdmision
      INNER JOIN $tablaAnioAdmision AS ana ON a.idAnioEscolar = ana.idAnioEscolar
      INNER JOIN $tablaAnioEscolar AS ae ON ana.idAnioEscolar = ae.idAnioEscolar
      INNER JOIN $tablaAlumno AS al ON aa.idAlumno = al.idAlumno
      INNER JOIN $tablaAlumnoGrado AS ag ON aa.idAlumno = ag.idAlumno
      INNER JOIN $tablaGrado AS g ON ag.idGrado = g.idGrado
      INNER JOIN $tablaNivel AS n ON g.idNivel = n.idNivel
      WHERE ana.idAnioEscolar IN ($aniosLectivo)");
    if ($stmt->execute()) {
      return $stmt->fetchAll();
    } else {
      return "error";
    }
  }

  /**
   * Obtiene el reporte de nuevos y antiguos.
   * 
   * @param string $tabla El nombre de la tabla en la base de datos.
   * @return array/string El reporte de nuevos y antiguos. 
   */
  static public function mdlGetReporteNuevosAntiguos($tabla)
  {
    $tablaAdmision = "admision";
    $tablaAlumno = "alumno";
    $tablaAnioAdmision = "anio_admision";
    $tablaAnioEscolar = "anio_escolar";
    $tablaAlumnoGrado = "alumno_grado";
    $tablaGrado = "grado";
    $tablaNivel = "nivel";
    $stmt = Connection::conn()->prepare("SELECT aa.idAdmisionAlumno, a.idAnioEscolar, ae.estadoAnio, aa.idAlumno, aa.estadoAdmisionAlumno, al.nombresAlumno, al.apellidosAlumno, g.descripcionGrado, n.descripcionNivel,al.nuevoAlumno
      FROM $tabla AS aa
      INNER JOIN $tablaAdmision AS a ON aa.idAdmision = a.idAdmision
      INNER JOIN $tablaAnioAdmision AS ana ON aa.idAdmisionAlumno = ana.idAdmisionAlumno
      INNER JOIN $tablaAnioEscolar AS ae ON ana.idAnioEscolar = ae.idAnioEscolar
      INNER JOIN $tablaAlumno AS al ON aa.idAlumno = al.idAlumno
      INNER JOIN $tablaAlumnoGrado AS ag ON aa.idAlumno = ag.idAlumno
      INNER JOIN $tablaGrado AS g ON ag.idGrado = g.idGrado
      INNER JOIN $tablaNivel AS n ON g.idNivel = n.idNivel
      WHERE ae.estadoAnio = 1 AND aa.estadoAdmisionAlumno = 2");
    if ($stmt->execute()) {
      return $stmt->fetchAll();
    } else {
      return "error";
    }
  }
}
