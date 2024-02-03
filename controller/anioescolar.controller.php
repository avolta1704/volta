<?php
date_default_timezone_set('America/Lima');

class ControllerAnioEscolar
{
  //  Crear nuevo Año Escolar
  public static function ctrCrearAnioEscolar($dataAnioEscolar)
  {
    $tabla = "anioescolar";
    foreach ($dataAnioEscolar as $value) {
      $datosAnioEscolar = array(
        "descripcionAnio" => $value["descripcionAnio"],
        "estadoAnio" => $value["estadoAnio"],
        "costoMatricula" => $value["costoMatricula"],
        "costoPension" => $value["costoPension"],
        "fechaCreacion" => date("Y-m-d H:i:s"),
        "fechaActualizacion" => date("Y-m-d H:i:s"),
        "usuarioCreacion" => $_SESSION["idUsuario"],
        "usuarioActualizacion" => $_SESSION["idUsuario"]
      );
      $response = ModelAnioEscolar::mdlCrearAnioEscolar($tabla, $datosAnioEscolar);
      if ($response == "ok") {
        $mensaje = ControllerFunciones::mostrarAlerta("success", "Correcto", "Año escolar creado correctamente", "listaAnioEscolar");
        echo $mensaje;
      } else {
        $mensaje = ControllerFunciones::mostrarAlerta("error", "Error", "Error al crear el año escolar", "listaAnioEscolar");
        echo $mensaje;
      }
    }
  }
}
