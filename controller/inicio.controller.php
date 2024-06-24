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
  public static function ctrObtenerTodoslosAlumnosAsignadosDocente($idUsuario){
    $tabla = "usuario";
    $response = ModelInicio::mdlObtenerTodoslosAlumnosAsignadosDocente($tabla, $idUsuario);
    return $response;
  }
  public static function ctrObtenerTotaldeCursosAsignados($idUsuario){
    $tabla = "usuario";
    $response = ModelInicio::mdlObtenerTotaldeCursosAsignados($tabla,$idUsuario);
    return $response;
  }
  public static function ctrObtenerTotalDocenterCursosporGrado(){
    $tabla = "grado";
    $response = ModelInicio::mdlObtenerTotalDocenterCursosporGrado($tabla);
    return $response;
  }
  public static function ctrObtenerNombreDocenteyCurso(){
    $tabla = "grado";
    $response = ModelInicio::mdlObtenerNombreDocenteyCurso($tabla);
    return $response;
  }
  public static function ctrObtenerTodoslosDocentesporTipo(){
    $tabla = "personal";
    $response = ModelInicio::mdlObtenerTodoslosDocentesporTipo($tabla);
    return $response;
  }
  public static function ctrObtenerTotalMasculinoFemeniniporGrados(){
    $tabla = "alumno";
    $response = ModelInicio::mdlObtenerTotalMasculinoFemeniniporGrados($tabla);
    return $response;
  }
  public static function ctrObtenerTodoslosAlumnosNuevosAntiguos(){
    $tabla = "alumno_anio_escolar";
    $response = ModelInicio::mdlObtenerTodoslosAlumnosNuevosAntiguos($tabla);
    return $response;
  }
  public static function ctrObtenerTodosPagosPendientesAlumnosApoderado($idAlumno){
    $tabla = "alumno";
    $response = ModelInicio::mdlObtenerTodosPagosPendientesAlumnosApoderado($tabla, $idAlumno);
    return $response;
  }
  public static function ctrObtenerFechaPagoApoderado($idAlumno){
    $tabla = "alumno";
    $response = ModelInicio::mdlObtenerFechaPagoApoderado($tabla, $idAlumno);
    return $response;
  }
  public static function ctrObtenerRegistroAsitenciaAlumnoApoderado($idAlumno){
    $tabla = "alumno";
    $response = ModelInicio::mdlObtenerRegistroAsitenciaAlumnoApoderado($tabla, $idAlumno);
    return $response;
  }
  public static function ctrObtenerDetallesAlumnoApoderado($idAlumno){
    $tabla = "alumno";
    $response = ModelInicio::mdlObtenerDetallesAlumnoApoderado($tabla, $idAlumno);
    return $response;
  }
}