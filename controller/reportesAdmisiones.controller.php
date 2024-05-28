<?php
class ControllerReportesAdmisiones
{
  /**
   * Obtiene el reporte de admisiones.
   *
   * @return array/string $respuesta Retorna un array con los datos de las admisiones o un string con un mensaje de error.
   */
  static public function ctrGetReporteAdmisiones()
  {
    $tabla = "admision_alumno";
    $respuesta = ModelReportesAdmisiones::mdlGetReporteAdmisiones($tabla);
    return $respuesta;
  }
}
