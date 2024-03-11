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
  //  crear postulante alumno extraordinario
  public static function ctrCrearAlumnoExtraordinaria()
  {
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    // acceder a la variable de sesión
    $idUsuario = $_SESSION["idUsuario"];
    // Crear postulante extraordinario
    if (isset($_POST["nombresAlumno"]) && isset($_POST["apellidosAlumno"])) {
      $tabla = "postulante";
      $datosPostulante = array(
        "nombrePostulante" => $_POST["nombresAlumno"],
        "apellidoPostulante" => $_POST["apellidosAlumno"],
        "dniPostulante" => $_POST["dniAlumno"],
        "fechaPostulacion" => $_POST["fechaIngreso"],
        "fechaNacimiento" => $_POST["fechaNacimiento"],
        "gradoPostulacion" => $_POST["gradoAlumno"],
        "estadoPostulante" => 3,
        "fechaCreacion" => date("Y-m-d H:i:s"),
        "fechaActualizacion" => date("Y-m-d H:i:s"),
        "usuarioCreacion" => $idUsuario,
        "usuarioActualizacion" => $idUsuario
      );
      $response = ModelPostulantes::mdlCrearPostulante($tabla, $datosPostulante);
      if ($response != "ok") {
        return "error al crear el postulante";
      }
    }
    // Crear alumno extraordinario
    if (isset($_POST["nombresAlumno"]) && isset($_POST["apellidosAlumno"])) {
      $tabla = "alumno";
      $dataAlumno = array(
        "nombresAlumno" => $_POST["nombresAlumno"],
        "apellidosAlumno" => $_POST["apellidosAlumno"],
        "sexoAlumno" => $_POST["sexoAlumno"],
        /* "estadoSiagie" => 1, */
        "estadoAlumno" => 1,
        /* "estadoMatricula" => 1, */
        "dniAlumno" => $_POST["dniAlumno"],
        "fechaNacimiento" => $_POST["fechaNacimiento"],
        "direccionAlumno" => $_POST["direccionAlumno"],
        "distritoAlumno" => $_POST["distrito"],
        "IEPProcedencia" => $_POST["iepProcedencia"],
        "seguroSalud" => $_POST["seguroSalud"],
        "fechaIngresoVolta" => $_POST["fechaIngreso"],
        "numeroEmergencia" => $_POST["numeroEmergencia"],
        "enfermedades" => $_POST["enfermedadesAlumno"],
        "fechaCreacion" => date("Y-m-d\TH:i:sP"),
        "fechaActualizacion" => date("Y-m-d\TH:i:sP"),
        "usuarioCreacion" => $idUsuario,
        "usuarioActualizacion" => $idUsuario
      );
      $response = ModelAlumnos::mdlCrearAlumno($tabla, $dataAlumno);
      if ($response != "ok") {
        return "error al crear el alumno";
      }
    }
    // Obtener el último postulante creado extraordinario
    $ultimoPostulante = ControllerPostulantes::ctrObtenerUltimoPostulanteCreado();
    // Verificar si se obtuvo el postulante
    if (!$ultimoPostulante) {
      return "error al obtener el último postulante";
    }
    // Obtener el último alumno creado extraordinario
    $ultimoAlumno = ControllerAlumnos::ctrObtenerUltimoAlumnoCreado();
    // Verificar si se obtuvo el alumno
    if (!$ultimoAlumno) {
      return "error al obtener el último alumno";
    }
    // Devolver el ID del último registro de admisión creado y el grado del postulante
    return array(
      "idPostulante" => $ultimoPostulante,
      "idAlumno" => $ultimoAlumno,
      "idGrado" => $_POST["gradoAlumno"]
    );
    // Si la actualización del estado fue exitosa y el estado es igual a 3=aprobado
    if (  return array = $alumnoExtraordinario(
      "idPostulante" => $ultimoPostulante,
      "idAlumno" => $ultimoAlumno,
      "idGrado" => $_POST["gradoAlumno"]);) {
      // Iniciar las funciones anidadas para crear grado y admision del alumno alumno
      if ($alumnoExtraordinario != false) {
        // Crear un nuevo registro del alumno creado en la tabla alumno_grado 
        $alumnoGradoAsignado = ControllerGradoAlumno::ctrRegistrarGradoAlumnoAdmision($alumnoExtraordinario);
        if ($alumnoGradoAsignado == "ok") {
          // Tomar el año escolar "estadoAnio 1 = actual 2 = anteriores" para el registro de postulante en la tabla anio_escolar
          $estadoAnio = 1;
          $anioEscolarActiva = ControllerAnioEscolar::ctrAnioEscolarActivoParaRegistroAlumno($estadoAnio);
          if ($anioEscolarActiva != false) {
            // Tomar el año escolar activo para el registro de postulante en la tabla admision
            $admisionAnioEscolar = ControllerAdmision::ctrAdmisionEscolarActivaRegistroPostulante($anioEscolarActiva, $alumnoExtraordinario);
            if ($admisionAnioEscolar != false) {
              // Crear un nuevo registro de alumno por la tabla postulante en la tabla admision_alumno
              $admisionAlumno = ControllerAdmision::ctrCrearAdmisionAlumno($admisionAnioEscolar, $alumnoExtraordinario);
              if ($admisionAlumno != false) {
                return "ok"; // Proceso completado exitosamente
                if ($response == "ok") {
                  $mensaje = ControllerFunciones::mostrarAlerta("success", "Correcto", "Alumno Creado Correctamente", "listaAlumnos");
                  echo $mensaje;
                } else {
                  $mensaje = ControllerFunciones::mostrarAlerta("error", "Error", "Error Al Crear nuevo Alumno", "listaAlumnos");
                  echo $mensaje;
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
        return "error";
      }
    }
  }
}