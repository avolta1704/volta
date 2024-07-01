<?php
date_default_timezone_set('America/Lima');

class ControllerInicio
{
  // Obtiene todos los alumnos por grado
  public static function ctrObtenertodoslosAlumnosporGrandos()
  {
    $response = ModelInicio::mdlObtenertodoslosAlumnosporGrandos();
    return $response;
  }
  // Obtiene todos las pensiones pendientes
  public static function ctrObtenertodaslasPensionesPendientes()
  {
    $response = ModelInicio::mdlObtenertodaslasPensionesPendientes();
    return $response;
  }
  // Obtiene todos los alumnos por anio
  public static function ctrObtenerTodoslosAlumnosporAnio()
  {
    $response = ModelInicio::mdlObtenerTodoslosAlumnosporAnio();
    return $response;
  }
  // Obtiene los montos recaudados por meses
  public static function ctrObtenerMontoRecaudadoporMeses()
  {
    $response = ModelInicio::mdlObtenerMontoRecaudadoporMeses();
    return $response;
  }
  // Obtiene todo el personal
  public static function ctrObtenerPersonalInicio()
  {
    $response = ModelInicio::mdlObtenerPersonalInicio();
    return $response;
  }
  // Obtiene el porcentaje de asistencia por meses
  public static function ctrObtenerAsistenciaporMeses($idUsuario){
    $tabla = "usuario";
    $response = ModelInicio::mdlObtenerAsistenciaporMeses($tabla, $idUsuario);
    return $response;
  }
  // Obtiene todas las competencias y notas
  public static function ctrObtenerTodaslasCompetenciasNotas($idUsuario){
    $tabla = "personal";
    $response = ModelInicio::mdlObtenerTodaslasCompetenciasNotas($tabla, $idUsuario);
    return $response;
  }
  // Obtiene todos los alumnos asignados al docente
  public static function ctrObtenerTodoslosAlumnosAsignadosDocente($idUsuario){
    $tabla = "usuario";
    $response = ModelInicio::mdlObtenerTodoslosAlumnosAsignadosDocente($tabla, $idUsuario);
    return $response;
  }
  // Obtiene el total de cursos asignados al docente
  public static function ctrObtenerTotaldeCursosAsignados($idUsuario){
    $tabla = "usuario";
    $response = ModelInicio::mdlObtenerTotaldeCursosAsignados($tabla,$idUsuario);
    return $response;
  }
  // Obtiene el total de docentes y cursos por grado
  public static function ctrObtenerTotalDocenterCursosporGrado(){
    $tabla = "grado";
    $response = ModelInicio::mdlObtenerTotalDocenterCursosporGrado($tabla);
    return $response;
  }
  // Obtiene los nombres de los docentes y los cursos
  public static function ctrObtenerNombreDocenteyCurso(){
    $tabla = "grado";
    $response = ModelInicio::mdlObtenerNombreDocenteyCurso($tabla);
    return $response;
  }
  // Obtiene todos los docentes por tipo
  public static function ctrObtenerTodoslosDocentesporTipo(){
    $tabla = "personal";
    $response = ModelInicio::mdlObtenerTodoslosDocentesporTipo($tabla);
    return $response;
  }
  // Obtiene cuantos alumnos son de sexo masculino y femenino
  public static function ctrObtenerTotalMasculinoFemeniniporGrados(){
    $tabla = "alumno";
    $response = ModelInicio::mdlObtenerTotalMasculinoFemeniniporGrados($tabla);
    return $response;
  }
  // Obtiene cuantos alumnos son nuevos y antiguos
  public static function ctrObtenerTodoslosAlumnosNuevosAntiguos(){
    $tabla = "alumno_anio_escolar";
    $response = ModelInicio::mdlObtenerTodoslosAlumnosNuevosAntiguos($tabla);
    return $response;
  }
  // Obtiene todos los pagos pendientes de los alumnos
  public static function ctrObtenerTodosPagosPendientesAlumnosApoderado($idAlumno){
    $tabla = "alumno";
    $response = ModelInicio::mdlObtenerTodosPagosPendientesAlumnosApoderado($tabla, $idAlumno);
    return $response;
  }
  // Obtiene la fecha de pago del alumno
  public static function ctrObtenerFechaPagoApoderado($idAlumno){
    $tabla = "alumno";
    $response = ModelInicio::mdlObtenerFechaPagoApoderado($tabla, $idAlumno);
    return $response;
  }
  // Obtiene el registro de asistencia del alumno
  public static function ctrObtenerRegistroAsitenciaAlumnoApoderado($idAlumno){
    $tabla = "alumno";
    $response = ModelInicio::mdlObtenerRegistroAsitenciaAlumnoApoderado($tabla, $idAlumno);
    $responseAnual = ModelInicio::mdlObtenerPorcentajesAnualAsistencia($tabla, $idAlumno); // Obtiene el porcentaje anual de asistencia
    $response = array_merge($response, $responseAnual); // Une los dos arrays
    return $response;
  }
  // Obtiene los detalles del alumno
  public static function ctrObtenerDetallesAlumnoApoderado($idAlumno){
    $tabla = "alumno";
    $response = ModelInicio::mdlObtenerDetallesAlumnoApoderado($tabla, $idAlumno);
    return $response;
  }
  // Obtiene todos los cursos asignados al alumno
  public static function ctrObtenerTodoslosCursosAsignadosAlumno($idAlumno){
    $tabla = "alumno";
    $response = ModelInicio::mdlObtenerTodoslosCursosAsignadosAlumno($tabla, $idAlumno);
    return $response;
  }
  // Obtiene todas las notas de los bimestres por cursos
  public static function ctrObtenerTodasNotasBimestresporCursos($idAlumno){
    $tabla = "alumno";
    $response = ModelInicio::mdlObtenerTodasNotasBimestresporCursos($tabla, $idAlumno);
    return $response;
  }
}