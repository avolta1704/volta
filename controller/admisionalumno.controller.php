<?php
date_default_timezone_set('America/Lima');

class ControllerAdmisionAlumno
{
  //todos los registros de admision
  public static function ctrGetAdmisionAlumnos()
  {
    $tabla = "admision_alumno";
    $listaAdmisionAlumnos = ModelAdmisionAlumno::mdlGetAdmisionAlumnos($tabla);
    return $listaAdmisionAlumnos;
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
  // Función principal para Crear Admision Extraordinaria creando al postulante en estado = 3 (aprobado) al alumno, al alumnno_grado,su admision  y admision_alumno
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
            $admisionAnioEscolar = ControllerAdmision::ctrAdmisionEscolarActivaRegistroPostulante($anioEscolarActiva, $codPostulanteEdit);
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
}