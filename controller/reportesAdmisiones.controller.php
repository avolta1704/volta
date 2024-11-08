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

  /**
   * Obtiene el reporte de admisiones por año lectivo.
   * 
   * @param array $aniosLectivo Array de los años seleccionados.
   * @return array/string $respuesta Retorna un array con los datos de las admisiones o un string con un mensaje de error.
   */
  static public function ctrGetReportesPorAnioLectivo($aniosLectivo)
  {
    $tabla = "admision_alumno";
    $respuesta = ModelReportesAdmisiones::mdlGetReportesPorAnioLectivo($tabla, $aniosLectivo);
    return $respuesta;
  }

  /**
   * Obtiene el reporte de nuevos y antiguos.
   * 
   * @return array/string $respuesta Retorna un array con los datos de las admisiones o un string con un mensaje de error.   * 
   */
  static public function ctrGetReporteNuevosAntiguos()
  {
    $tabla = "admision_alumno";
    $respuesta = ModelReportesAdmisiones::mdlGetReporteNuevosAntiguos($tabla);
    return $respuesta;
  }

  /**
   * Obtiene el reporte de edad y sexo.
   * 
   * @return array/string $respuesta Retorna un array con los datos de las admisiones o un string con un mensaje de error.
   */
  static public function ctrGetReporteEdadSexo()
  {
    $tabla = "admision_alumno";
    $respuesta = ModelReportesAdmisiones::mdlGetReporteEdadSexo($tabla);
    return $respuesta;
  }
}
