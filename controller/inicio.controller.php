<?php
date_default_timezone_set('America/Lima');

class ControllerInicio
{
  public static function ctrObtenertodoslosAlumnosporGrandos()
  {
    $response = ModelInicio::mdlObtenertodoslosAlumnosporGrandos();
    return $response;
  }
  public static function ctrObtenertodaslasPensionesPendientes()
  {
    $response = ModelInicio::mdlObtenertodaslasPensionesPendientes();
    return $response;
  }
  public static function ctrObtenerTodoslosAlumnosporAnio()
  {
    $response = ModelInicio::mdlObtenerTodoslosAlumnosporAnio();
    return $response;
  }
  public static function ctrObtenerMontoRecaudadoporMeses()
  {
    $response = ModelInicio::mdlObtenerMontoRecaudadoporMeses();
    return $response;
  }
  public static function ctrObtenerPersonalInicio()
  {
    $response = ModelInicio::mdlObtenerPersonalInicio();
    return $response;
  }
}