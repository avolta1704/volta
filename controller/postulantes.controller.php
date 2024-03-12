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

  // Función principal para actualizar el estado del postulante y solo  crear al alumno si su admision es aprobada = 3
  public static function ctrActualizarEstadoPostulante($codPostulanteEdit, $estadoPostulanteEdit)
  {
    $tabla = "postulante";
    $estadoPostulanteActual = ModelPostulantes::mdlObtenerEstadoPostulante($tabla, $codPostulanteEdit);

    // Verificar si el estado actual es igual al estado que se quiere actualizar
    if ($estadoPostulanteActual["estadoPostulante"] == $estadoPostulanteEdit) {
      // Si son iguales, devolver "error"
      return "error";
    }
    $estadoPostulanteActual = $estadoPostulanteEdit;

    $dataPostulanteEdit = array(
      "idPostulante" => $codPostulanteEdit,
      "estadoPostulante" => $estadoPostulanteActual,
      "fechaActualizacion" => date("Y-m-d H:i:s"),
    );

    $actualizarEstado = ModelPostulantes::mdlActualizarEstadoPostulante($tabla, $dataPostulanteEdit);
    // Si la actualización del estado fue exitosa y el estado es igual a 3=aprobado
    if ($actualizarEstado == "ok" && $estadoPostulanteActual == 3) {
      // Iniciar las funciones anidadas para crear un alumno
      $alumnoAdmision = ControllerAlumnos::ctrCrearAlumnoAdmision($codPostulanteEdit);
      if ($alumnoAdmision != false) {
        // Crear un nuevo registro del alumno creado en la tabla alumno_grado 
        $alumnoGradoAsignado = ControllerGradoAlumno::ctrRegistrarGradoAlumnoAdmision($alumnoAdmision);
        if ($alumnoGradoAsignado == "ok") {
          // Tomar el año escolar "estadoAnio 1 = actual 2 = anteriores" para el registro de postulante en la tabla anio_escolar
          $estadoAnio = 1;
          $anioEscolarActiva = ControllerAnioEscolar::ctrAnioEscolarActivoParaRegistroAlumno($estadoAnio);
          if ($anioEscolarActiva != false) {
            // Tomar el año escolar activo para el registro de postulante en la tabla admision
            $tipoAdmision = 1; // 1 = ordinario, 2 = extraordinario
            $admisionAnioEscolar = ControllerAdmision::ctrAdmisionEscolarActivaRegistroPostulante($anioEscolarActiva, $codPostulanteEdit,$tipoAdmision);
            if ($admisionAnioEscolar != false) {
              // Crear un nuevo registro de alumno por la tabla postulante en la tabla admision_alumno
              $admisionAlumno = ControllerAdmision::ctrCrearAdmisionAlumno($admisionAnioEscolar, $alumnoAdmision);
              if ($admisionAlumno != false) {
                return "ok"; // Proceso completado exitosamente
              } else {
                return "error";
              }
            } else {
              return "error";
            }
          } else {
            return "error";
          }
        } else {
          return "error";
        }
      } else {
        return "error";
      }
    } else {
      return "ok"; // Si el estado no es igual a 3, no se inicia el proceso de crear el alumno
    }
  }
  // Obtener el último postulante creado extraordinario
  public static function ctrObtenerUltimoPostulanteCreado()
  {
    $tabla = "postulante";
    $response = ModelPostulantes::mdlObtenerUltimoPostulanteCreado($tabla);
    return $response;
  }

}
