<?php
date_default_timezone_set('America/Lima');

class ControllerAdmision
{
  // crear admision de postulante
  // anioEscolarActiva = idAnioEscolar, codPostulanteEdit = idPostulante // y admision extraordinario // $tipoAdmision 1 = ordinario, 2 = extraordinario
  public static function ctrAdmisionEscolarActivaRegistroPostulante($anioEscolarActiva, $codPostulanteEdit,$tipoAdmision)
  {
    //sesión esté iniciada
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    // acceder a la variable de sesión
    $idUsuario = $_SESSION["idUsuario"];
    // usar por el origen del dato  $tipoAdmision 1 = ordinario, 2 = extraordinario
    $dataPostulanteAdmision = array(
      "idAnioEscolar" => $anioEscolarActiva,
      "idPostulante" => $codPostulanteEdit,
      "fechaAdmision" => date("Y-m-d"),
      "tipoAdmision" => $tipoAdmision,
      "fechaCreacion" => date("Y-m-d H:i:s"),
      "fechaActualizacion" => date("Y-m-d H:i:s"),
      "usuarioCreacion" => $idUsuario,
      "usuarioActualizacion" => $idUsuario
    );
    $table = "admision";
    $result = ModelAdmision::mdlCrearAdmisionPostulate($table, $dataPostulanteAdmision);
    if ($result == "ok") {
      $admisionAnioEscolar = ModelAdmision::mdlUltimoRegistroAdmisionCreado($table);
      return $admisionAnioEscolar;
    }
  }
  //registrar al alumno en alumno_admision botn aprobado
  // y admision extraordinario
  //admisionAnioEscolar = idAdmision, alumnoAdmision= idAlumno, alumnoAdmision=idGrado
  public static function ctrCrearAdmisionAlumno($admisionAnioEscolar, $alumnoAdmision)
  {
    //sesión esté iniciada
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    // acceder a la variable de sesión
    $idUsuario = $_SESSION["idUsuario"];
    $dataAlumnoAdmision = array(
      "idAdmision" => $admisionAnioEscolar,
      "idAlumno" => $alumnoAdmision["idAlumno"],
      "estadoAdmisionAlumno" => 1,
      "fechaCreacion" => date("Y-m-d H:i:s"),
      "fechaActualizacion" => date("Y-m-d H:i:s"),
      "usuarioCreacion" => $idUsuario,
      "usuarioActualizacion" => $idUsuario
    );
    $table = "admision_alumno";
    $result = ModelAdmision::mdlCrearAlumnoAdmision($table, $dataAlumnoAdmision);
    if ($result == "ok") {
      return "ok";
    } else {
      return "error";
    }
  }
}