<?php
date_default_timezone_set('America/Lima');

class ControllerAdmision
{
  // crear admision de postulante
  public static function ctrAdmisionEscolarActivaRegistroPostulante($anioEscolarActiva, $codPostulanteEdit, $tipoAdmision)
  {
    // usar por el origen del dato  $tipoAdmision 1 = ordinario, 2 = extraordinario
    $dataPostulanteAdmision = array(
      "idAnioEscolar" => $anioEscolarActiva,
      "idPostulante" => $codPostulanteEdit,
      "fechaAdmision" => date("Y-m-d"),
      "tipoAdmision" => $tipoAdmision,
      "fechaCreacion" => date("Y-m-d H:i:s"),
      "fechaActualizacion" => date("Y-m-d H:i:s"),
      "usuarioCreacion" => $_SESSION["idUsuario"],
      "usuarioActualizacion" => $_SESSION["idUsuario"]
    );
    $table = "admision";
    $result = ModelAdmision::mdlCrearAdmisionPostulate($table, $dataPostulanteAdmision);
    if ($result == "ok") {
      $admisionAnioEscolar = ModelAdmision::mdlUltimoRegistroAdmisionCreado($table);
      return $admisionAnioEscolar;
    }
  }
}