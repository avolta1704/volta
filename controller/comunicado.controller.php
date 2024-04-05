<?php
date_default_timezone_set('America/Lima');

class ControllerComunicado
{
  //  obtener los alumnos para pagoAlumnos para su comunicado de pago
  public static function ctrGetAllComunicadoPago()
  {
    $tabla = "alumno";
    $listaAlumnos = ModelComunicado::mdlGetAllPagoAlumnos($tabla);
    return $listaAlumnos;
  }
  //datos del alumno para el comunicado de pago
  public static function ctrGetDatosAlumnoComunicado($codAlumno)
  {
    $tabla = "alumno";
    $listaAlumnos = ModelComunicado::mdlGetDatosAlumnoComunicado($tabla,$codAlumno);
    return $listaAlumnos;
  }
  //cronograma de pago para el comunicado de pago
  public static function ctrGetCronogramaPagoComunicado($codCronograma)
  {
    $tabla = "cronograma_pago";
    $listaAlumnos = ModelComunicado::mdlGetCronogramaPagoComunicado($tabla,$codCronograma);
    return $listaAlumnos;
  }



}
