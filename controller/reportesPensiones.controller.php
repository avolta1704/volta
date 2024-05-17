<?php
date_default_timezone_set('America/Lima');

class ControllerReportesPensiones
{
  public static function ctrGetCronogramasPagoPendientes()
  {
    // Obtener todos los cronogramas de pago de deuda pasada
    $respuesta = ModelReportesPensiones::mdlGetCronogramasPagoPendientes();
    return $respuesta;
  }
}
