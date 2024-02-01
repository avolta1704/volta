<?php
date_default_timezone_set('America/Lima');

class ControllerAlumnos
{
  //  Listar alumnos
  public static function ctrGetAlumnos()
  {
    $tabla = "alumno";
    $listaAlumnos = ModelAlumnos::mdlGetAlumnos($tabla);
    return $listaAlumnos;
  }

  //  Crear nuevo alumno
  public static function ctrCrearAlumno()
  {
    if (isset($_POST["nombresAlumno"]) && (isset($_POST["apellidosAlumno"]))) {
      $tabla = "alumno";
      $dataAlumno = array(
        "nombresAlumno" => $_POST["nombresAlumno"],
        "apellidosAlumno" => $_POST["apellidosAlumno"],
        "sexoAlumno" => $_POST["sexoAlumno"],
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
        "fechaActualizacion" => date("Y-m-d\TH:i:sP")
      );
      $nuevoAlumno = ModelAlumnos::mdlCrearAlumno($tabla, $dataAlumno);

      if ($nuevoAlumno == "ok") {
        $listaApoderados = json_decode($_POST["listaApoderados"], true);
        //  Se obtiene la lista de apoderados, si es vacía o nula, solo se crea el alumno. Sino se crea cada apoderado.
        if ($listaApoderados != null || $listaApoderados != "") {
          $codAlumno = self::ctrObtenerUltimoAlumno();
          foreach ($listaApoderados as $value) {
            $dataApoderado = array(
              "numeroApoderado" => $value["numeroApoderado"],
              "tipoApoderado" => $value["tipoApoderado"],
              "correoApoderado" => $value["correoApoderado"],
              "nombreApoderado" => $value["nombreApoderado"],
              "apellidoApoderado" => $value["apellidoApoderado"],
              "fechaCreacion" => date("Y-m-d\TH:i:sP"),
              "fechaActualizacion" => date("Y-m-d\TH:i:sP"),
            );
            $nuevoApoderado = ControllerApoderados::ctrCrearApoderadoAlumno($dataApoderado);
            $codApoderado = ControllerApoderados::ctrObtenerUltimoApoderado();
            $dataApoderadoAlumno = array(
              "idAlumno" => $codAlumno["idAlumno"],
              "idApoderado" => $codApoderado["idApoderado"],
              "fechaCreacion" => date("Y-m-d\TH:i:sP"),
              "fechaActualizacion" => date("Y-m-d\TH:i:sP")
            );
            $response = self::ctrAsignarAlumnoApoderado($dataApoderadoAlumno);
          }
          //  Le asignamos el grado del alumno
          $dataAlumnoGrado = array(
            "idAlumno" => $codAlumno["idAlumno"],
            "idGrado" => $_POST["gradoAlumno"],
            "estadoGradoAlumno" => 1,
            "fechaCreacion" => date("Y-m-d\TH:i:sP"),
            "fechaActualizacion" => date("Y-m-d\TH:i:sP")
          );
          ControllerGradoAlumno::ctrAsignarGradoAlumno($dataAlumnoGrado);
        } else {
          $response = "ok";
        }
        if ($response == "ok") {
          ControllerFunciones::mostrarAlerta("success", "Correcto", "Alumno Creado Correctamente", "listaAlumnos");
        } else {
          ControllerFunciones::mostrarAlerta("error", "Error", "Error Al Crear nuevo Alumno", "listaAlumnos");
        }
      } else {
        ControllerFunciones::mostrarAlerta("error", "Error", "Error Al Crear nuevo Alumno", "listaAlumnos");
      }
    } else {
      ControllerFunciones::mostrarAlerta("error", "Error", "Error Al Crear nuevo Alumno", "listaAlumnos");
    }
  }

  //  Obtener ultimo alumno creado
  public static function ctrObtenerUltimoAlumno()
  {
    $tabla = "alumno";
    $response = ModelAlumnos::mdlObtenerUltimoAlumno($tabla);
    return $response;
  }

  //  Asignar alumno a apoderado
  public static function ctrAsignarAlumnoApoderado($dataApoderadoAlumno)
  {
    $tabla = "apoderado_alumno";
    $response = ModelAlumnos::mdlAsignarAlumnoApoderado($tabla, $dataApoderadoAlumno);
    return $response;
  }
}
