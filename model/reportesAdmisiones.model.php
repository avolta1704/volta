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
    $stmt = Connection::conn()->prepare("SELECT aa.idAdmisionAlumno, a.idAnioEscolar, ae.estadoAnio, aa.idAlumno, aa.estadoAdmisionAlumno, al.nombresAlumno, al.apellidosAlumno
      FROM $tabla AS aa
      INNER JOIN $tablaAdmision AS a ON aa.idAdmision = a.idAdmision
      INNER JOIN $tablaAñoEscolar AS ae ON a.idAnioEscolar = ae.idAnioEscolar
      INNER JOIN $tablaAlumno AS al ON aa.idAlumno = al.idAlumno
      WHERE ae.estadoAnio = 1");
    if ($stmt->execute()) {
      return $stmt->fetchAll();
    } else {
      return "error";
    }
  }
}
