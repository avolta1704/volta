<?php
date_default_timezone_set('America/Lima');

class ControllerGradoAlumno
{
  //  Asignar grado a alumno
  public static function ctrAsignarGradoAlumno($dataAlumnoGrado)
  {
    $tabla = "alumno_grado";
    $response = ModelGradoAlumno::mdlAsignarGradoAlumno($tabla, $dataAlumnoGrado);
    return $response;
  }
  //  crear Grado admision de postulante-alumno  alumnoAdmision= idAlumno, alumnoAdmision=idGrado // y admision extraordinario
  public static function ctrRegistrarGradoAlumnoAdmision($alumnoAdmision)
  {
    //sesión esté iniciada
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    // acceder a la variable de sesión
    $idUsuario = $_SESSION["idUsuario"];
    $dataGradoAlumnoAdmision = array(
      "idAlumno" => $alumnoAdmision["idAlumno"],
      "idGrado" => $alumnoAdmision["idGrado"],
      "estadoGradoAlumno" => 1, // 1 = en curso
      "fechaCreacion" => date("Y-m-d H:i:s"),
      "fechaActualizacion" => date("Y-m-d H:i:s"),
      "usuarioCreacion" => $idUsuario,
      "usuarioActualizacion" => $idUsuario
    );
    $table = "alumno_grado";
    $result = ModelGradoAlumno::mdlCrearGradoAlumnoAdmision($table, $dataGradoAlumnoAdmision);
    if ($result == "ok") {
      return "ok";
    } else {
      return "error";
    }
  }
}