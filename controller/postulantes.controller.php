<?php
date_default_timezone_set('America/Lima');

class ControllerPostulantes
{
  //  Obtener todos los postulantes
  public static function ctrGetAllPostulantes()
  {
    $tabla = "postulante";
    $listPostulantes = ModelPostulantes::mdlGetAllPostulantes($tabla);
    return $listPostulantes;
  }

  //  Registrar nuevo postulante
  public static function ctrCrearPostulante()
  {
    if (isset($_POST["nombrePostulante"]) && isset($_POST["apellidoPostulante"])) {
      $tabla = "postulante";
      $datosPostulante = array(
        "nombrePostulante" => $_POST["nombrePostulante"],
        "apellidoPostulante" => $_POST["apellidoPostulante"],
        "dniPostulante" => $_POST["dniPostulante"],
        "fechaPostulacion" => $_POST["fechaPostulacion"],
        "fechaNacimiento" => $_POST["fechaNacimiento"],
        "gradoPostulacion" => $_POST["gradoAlumno"],
        "estadoPostulante" => 1,
        "fechaCreacion" => date("Y-m-d H:i:s"),
        "fechaActualizacion" => date("Y-m-d H:i:s")
      );
      $response = ModelPostulantes::mdlCrearPostulante($tabla, $datosPostulante);
      if ($response == "ok") {
        ControllerFunciones::mostrarAlerta("success", "Correcto", "Postulante creado correctamente", "listaPostulantes");
      } else {
        ControllerFunciones::mostrarAlerta("error", "Error", "Error al crear el postulante", "listaPostulantes");
      }
    } else {
      ControllerFunciones::mostrarAlerta("error", "Error", "Error al crear el postulante", "listaPostulantes");
    }
  }
}
