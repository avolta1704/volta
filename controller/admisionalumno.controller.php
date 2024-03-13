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
    if (isset($_POST["nombresAlumno"]) && isset($_POST["apellidosAlumno"])) {
      // Crear postulante extraordinario
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
        "usuarioCreacion" => $_SESSION["idUsuario"],
        "usuarioActualizacion" => $_SESSION["idUsuario"]
      );
      $response = ModelPostulantes::mdlCrearPostulante($tabla, $datosPostulante);
      // Crear alumno extraordinario
      if ($response == "ok") {
        $tabla = "alumno";
        $dataAlumno = array(
          "nombresAlumno" => $_POST["nombresAlumno"],
          "apellidosAlumno" => $_POST["apellidosAlumno"],
          "sexoAlumno" => $_POST["sexoAlumno"],
          "estadoSiagie" => 1,//Activo
          "estadoAlumno" => 3,//estado extraordinario
          "estadoMatricula" => 1,
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
          "usuarioCreacion" => $_SESSION["idUsuario"],
          "usuarioActualizacion" => $_SESSION["idUsuario"]
        );
        $response = ModelAlumnos::mdlCrearAlumno($tabla, $dataAlumno);
        if ($response == "ok") {
          // Obtener el último postulante creado extraordinario
          $ultimoPostulanteCreado = ControllerPostulantes::ctrObtenerUltimoPostulanteCreado();
          if ($ultimoPostulanteCreado) {
            // Obtener el último alumno creado extraordinario
            $ultimoAlumnoCreado = ControllerAlumnos::ctrObtenerUltimoAlumnoCreado();
            // Crear un array de datos de el id de último registro de postulante, alumno  y el grado del postulante del $_POST gradoAlumno
            if ($ultimoAlumnoCreado) {
              $alumnoExtraordinario = array(
                "idPostulante" => intval($ultimoPostulanteCreado),
                "idAlumno" => intval($ultimoAlumnoCreado),
                "idGrado" => intval($_POST["gradoAlumno"])
              );
              //funcion para agregar apoderado a alumno solo si listaApoderados contiene datos 
              if (isset($_POST["listaApoderados"]) && $_POST["listaApoderados"] != "") {
                $listaApoderados = json_decode($_POST["listaApoderados"], true);
                foreach ($listaApoderados as $value) {
                  $dataApoderado = array(
                    "numeroApoderado" => $value["numeroApoderado"],
                    "tipoApoderado" => $value["tipoApoderado"],
                    "correoApoderado" => $value["correoApoderado"],
                    "nombreApoderado" => $value["nombreApoderado"],
                    "apellidoApoderado" => $value["apellidoApoderado"],
                    "fechaCreacion" => date("Y-m-d\TH:i:sP"),
                    "fechaActualizacion" => date("Y-m-d\TH:i:sP"),
                    "usuarioCreacion" => $_SESSION["idUsuario"],
                    "usuarioActualizacion" => $_SESSION["idUsuario"]
                  );
                  $nuevoApoderado = ControllerApoderados::ctrCrearApoderadoAlumno($dataApoderado);
                  $codApoderado = ControllerApoderados::ctrObtenerUltimoApoderado();
                  $dataApoderadoAlumno = array(
                    "idAlumno" => $alumnoExtraordinario['idAlumno'],
                    "idApoderado" => $codApoderado["idApoderado"],
                    "fechaCreacion" => date("Y-m-d\TH:i:sP"),
                    "fechaActualizacion" => date("Y-m-d\TH:i:sP"),
                    "usuarioCreacion" => $_SESSION["idUsuario"],
                    "usuarioActualizacion" => $_SESSION["idUsuario"]
                  );
                  $response = ControllerAlumnos::ctrAsignarAlumnoApoderado($dataApoderadoAlumno);
                }
              }
              // Crear un nuevo registro del alumno creado en la tabla alumno_grado extraordiario
              $alumnoGradoAsignado = ControllerGradoAlumno::ctrRegistrarGradoAlumnoAdmision($alumnoExtraordinario);
              if ($alumnoGradoAsignado == "ok") {
                // Tomar el año escolar "estadoAnio 1 = actual 2 = anteriores" para el registro de postulante en la tabla anio_escolar extraordiario
                $estadoAnio = 1;
                $anioEscolarActiva = ControllerAnioEscolar::ctrAnioEscolarActivoParaRegistroAlumno($estadoAnio);
                if ($anioEscolarActiva != false) {
                  // Tomar el año escolar activo para el registro de postulante en la tabla admision extraordiario
                  $codPostulante = $alumnoExtraordinario['idPostulante'];
                  $tipoAdmision = 2; // 1 = ordinario, 2 = extraordinario
                  $admisionAnioEscolar = ControllerAdmision::ctrAdmisionEscolarActivaRegistroPostulante($anioEscolarActiva, $codPostulante,$tipoAdmision);
                  if ($admisionAnioEscolar != false) {
                    // Crear un nuevo registro de alumno por la tabla postulante en la tabla admision_alumno extraordiario
                    $admisionAlumno = ControllerAdmision::ctrCrearAdmisionAlumno($admisionAnioEscolar, $alumnoExtraordinario);
                    if ($admisionAlumno != false) {
                      // Proceso completado exitosamente
                      $mensaje = ControllerFunciones::mostrarAlerta("success", "Correcto", "Alumno Creado Correctamente", "listaAdmisionAlumnos");
                      echo $mensaje;
                      return "ok";
                    } else {
                      $mensaje = ControllerFunciones::mostrarAlerta("error", "Error", "Error Al Crear nuevo Alumno", "listaAdmisionAlumnos");
                      echo $mensaje;
                      return "error";
                    }
                  } else {
                    $mensaje = ControllerFunciones::mostrarAlerta("error", "Error", "Error Al Crear nuevo Alumno", "listaAdmisionAlumnos");
                    echo $mensaje;
                    return "error";
                  }
                } else {
                  $mensaje = ControllerFunciones::mostrarAlerta("error", "Error", "Error Al Crear nuevo Alumno", "listaAdmisionAlumnos");
                  echo $mensaje;
                  return "error";
                }
              } else {
                $mensaje = ControllerFunciones::mostrarAlerta("error", "Error", "Error Al Crear nuevo Alumno", "listaAdmisionAlumnos");
                echo $mensaje;
                return "error";
              }
            } else {
              $mensaje = ControllerFunciones::mostrarAlerta("error", "Error", "Error Al Crear nuevo Alumno", "listaAdmisionAlumnos");
              echo $mensaje;
              return "error";
            }
          } else {
            $mensaje = ControllerFunciones::mostrarAlerta("error", "Error", "Error Al Crear nuevo Alumno", "listaAdmisionAlumnos");
            echo $mensaje;
            return "error";
          }
        } else {
          $mensaje = ControllerFunciones::mostrarAlerta("error", "Error", "Error Al Crear nuevo Alumno", "listaAdmisionAlumnos");
          echo $mensaje;
          return "error";
        }
      } else {
        $mensaje = ControllerFunciones::mostrarAlerta("error", "Error", "Error Al Crear nuevo Alumno", "listaAdmisionAlumnos");
        echo $mensaje;
        return "error";
      }
    }
  }
  
}
