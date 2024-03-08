<?php
date_default_timezone_set('America/Lima');

class ControllerAdmision
{
  // crear admision de postulante
  // listAnioEscolarActiva = idAnioEscolar, codPostulanteEdit = idPostulante
  public static function ctrAdmisionEscolarActivaRegistroPostulante($listAnioEscolarActiva, $codPostulanteEdit)
  {
    //sesión esté iniciada
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    // acceder a la variable de sesión
    $idUsuario = $_SESSION["idUsuario"];
    $dataPostulanteAdmision = array(
      "idAnioEscolar" => $listAnioEscolarActiva,
      "idPostulante" => $codPostulanteEdit,
      "fechaAdmision" => date("Y-m-d"),
      "tipoAdmision" => 1,
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