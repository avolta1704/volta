<?php
date_default_timezone_set('America/Lima');

class ControllerReportesComunicados
{

  /**
   * Obtiene todos los alumnos con comunicados.
   *
   * @return array Retorna un array con los datos de los alumnos que tienen comunicados.
   */
  public static function ctrGetAllAlumnosConComunicados()
  {
    $table = "comunicacion_pago";
    $comunicados = ModelReportesComunicados::mdlGetAllAlumnosConComunicados($table);
    return $comunicados;
  }
}
