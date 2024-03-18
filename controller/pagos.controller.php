<?php
date_default_timezone_set('America/Lima');

class ControllerPagos
{
  //  Listar alumnos
  public static function ctrGetAllPagos()
  {
    $tabla = "pago";
    $listaPagos = ModelPagos::mdlGetAllPagos($tabla);
    return $listaPagos;
  }

}
