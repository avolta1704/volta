<?php
date_default_timezone_set('America/Lima');


class ControllerApoderadoAlumno
{
  //  Crear apoderado_alumno
  public static function ctrCrearApoderadoAlumno($listaApoderados, $idAlumno)
  {
    $table = "apoderado_alumno";
    //  Si no tiene apoderados regresará ok, pero no se crearan sus apoderados directamente
    if ($listaApoderados == null || $listaApoderados == "") {
      $response = "ok";
    } else {
      $listaApoderados = json_decode($listaApoderados, true);
      foreach ($listaApoderados as $key => $value) {
        $dataCreate = array(
          "idApoderado" => $value[$key],
          "idAlumno" => $idAlumno,
          "fechaCreacion" => date("Y-m-d H:i:s"),
          "fechaActualizacion" => date("Y-m-d H:i:s"),
          "usuarioCreacion" => $_SESSION["idUsuario"],
          "usuarioActualizacion" => $_SESSION["idUsuario"]
        );
        $response = ModelApoderadoAlumno::mdlCrearApoderadoAlumno($table, $dataCreate);
      }
    }
    return $response;
  }
}
