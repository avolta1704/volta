<?php
date_default_timezone_set('America/Lima');
class ControllerAnioAdmision
{
  //  Crear anio_admision
  public static function ctrCrearAnioAdmision($admisionAlumno, $anioEscolar)
  {
    $table = "anio_admision";
    $dataCreate = array(
      "idAdmisionAlumno" => $admisionAlumno,
      "idAnioEscolar" => $anioEscolar,
      "fechaCreacion" => date("Y-m-d H:i:s"),
      "fechaActualizacion" => date("Y-m-d H:i:s"),
      "usuarioCreacion" => $_SESSION["idUsuario"],
      "usuarioActualizacion" => $_SESSION["idUsuario"]
    );
    $response = ModelAnioAdmision::mdlCrearAnioAdmision($table, $dataCreate);
    return $response;
  }
}

