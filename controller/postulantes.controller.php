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
        "fechaActualizacion" => date("Y-m-d H:i:s"),
        "usuarioCreacion" => $_SESSION["idUsuario"],
        "usuarioActualizacion" => $_SESSION["idUsuario"]
      );
      $response = ModelPostulantes::mdlCrearPostulante($tabla, $datosPostulante);
      if ($response == "ok") {
        $mensaje = ControllerFunciones::mostrarAlerta("success", "Correcto", "Postulante creado correctamente", "listaPostulantes");
        echo $mensaje;
      } else {
        $mensaje = ControllerFunciones::mostrarAlerta("error", "Error", "Error al crear el postulante", "listaPostulantes");
        echo $mensaje;
      }
    }
  }

  //  Eliminar postulante
  public static function ctrBorrarPostulante()
  {
    if (isset($_GET["codPostulanteEliminar"])) {
      $tabla = "postulante";
      $codPostulante = $_GET["codPostulanteEliminar"];
      $response = ModelPostulantes::mdlBorrarPostulante($tabla, $codPostulante);
      if ($response == "ok") {
        $mensaje = ControllerFunciones::mostrarAlerta("success", "Correcto", "Postulante eliminado correctamente", "listaPostulantes");
        echo $mensaje;
      } else {
        $mensaje = ControllerFunciones::mostrarAlerta("error", "Error", "Error al eliminar el postulante", "listaPostulantes");
        echo $mensaje;
      }
    }
  }

  //  Editar postulante
  public static function ctrEditarPostulante()
  {
    if (isset($_POST["codPostulante"]) && isset($_POST["editarNombre"])) {
      $tabla = "postulante";
      $datosPostulante = array(
        "idPostulante" => $_POST["codPostulante"],
        "nombrePostulante" => $_POST["editarNombre"],
        "apellidoPostulante" => $_POST["editarApellido"],
        "dniPostulante" => $_POST["editarDNI"],
        "fechaPostulacion" => $_POST["editarFechaPostulacion"],
        "fechaNacimiento" => $_POST["editarFechaNacimiento"],
        "gradoPostulacion" => $_POST["editarGrado"],
        "fechaActualizacion" => date("Y-m-d H:i:s"),
        "usuarioActualizacion" => $_SESSION["idUsuario"]
      );
      $response = ModelPostulantes::mdlEditarPostulante($tabla, $datosPostulante);
      if ($response == "ok") {
        $mensaje = ControllerFunciones::mostrarAlerta("success", "Correcto", "Postulante editado correctamente", "listaPostulantes");
        echo $mensaje;
      } else {
        $mensaje = ControllerFunciones::mostrarAlerta("error", "Error", "Error al editar el postulante", "listaPostulantes");
        echo $mensaje;
      }
    }
  }

  //  Obtener datos del postulante para editar
  public static function ctrGetPostulanteById($codPostulante)
  {
    $tabla = "postulante";
    $dataPostulante = ModelPostulantes::mdlGetPostulanteById($tabla, $codPostulante);
    return $dataPostulante;
  }

  //  Actualizar estado del postulante
  public static function ctrActualizarEstadoPostulante($codPostulanteEdit, $estadoPostulanteEdit)
  {
    $tabla = "postulante";

    // Obtener el estado actual del postulante
    $estadoPostulanteActual = ModelPostulantes::mdlObtenerEstadoPostulante($tabla, $codPostulanteEdit);

    // Verificar si el estado actual es igual al estado que se quiere actualizar
    if ($estadoPostulanteActual["estadoPostulante"] != $estadoPostulanteEdit) {
      // Si no son iguales, actualizar el estado actual con el estado que se quiere actualizar
      $estadoPostulanteActual = $estadoPostulanteEdit;
    }

    $dataPostulanteEdit = array(
      "idPostulante" => $codPostulanteEdit,
      "estadoPostulante" => $estadoPostulanteActual,
      "fechaActualizacion" => date("Y-m-d H:i:s"),
      "usuarioActualizacion" => $_SESSION["idUsuario"]
    );

    $actualizarEstado = ModelPostulantes::mdlActualizarEstadoPostulante($tabla, $dataPostulanteEdit);

    if($actualizarEstado == "ok") {
      return "ok";
    } else {
      return "error";
    }
    
  }
}
