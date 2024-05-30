<?php
date_default_timezone_set('America/Lima');
class ControllerAlumnoAnioEscolar
{
  //  Crear anio_admision
  public static function ctrCrearAlumnoAnioEscolar($arrayAnio)
  {
    $tabla = "alumno_anio_escolar";
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    $arrayAnio = array(
      "idAnioEscolar" => $arrayAnio["idAnioEscolar"],
      "idAlumno" => $arrayAnio["idAlumno"],
      "idGrado" => $arrayAnio["idGrado"],
      "fechaCreacion" => date("Y-m-d H:i:s"),
      "fechaActualizacion" => date("Y-m-d H:i:s"),
      "usuarioCreacion" => $_SESSION["idUsuario"],
      "usuarioActualizacion" => $_SESSION["idUsuario"]
    );
    $response = ModelAlumnoAnioEscolar::mdlCrearAlumnoAnioEscolar($tabla, $arrayAnio);
    return $response;
  }
}

