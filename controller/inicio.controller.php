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
  public static function ctrObtenerAsistenciaporMeses($idUsuario){
    $tabla = "usuario";
    $response = ModelInicio::mdlObtenerAsistenciaporMeses($tabla, $idUsuario);
    return $response;
  }
  public static function ctrObtenerTodaslasCompetenciasNotas($idUsuario){
    $tabla = "personal";
    $response = ModelInicio::mdlObtenerTodaslasCompetenciasNotas($tabla, $idUsuario);
    return $response;
  }
}