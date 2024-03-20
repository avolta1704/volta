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

  //  Crear nuevo alumno//
 /*  public static function ctrCrearAlumnoExtraordinaria()
  {
    if (isset($_POST["nombresAlumno"]) && isset($_POST["apellidosAlumno"])) {
      $tabla = "alumno";
      $dataAlumno = array(
        "nombresAlumno" => $_POST["nombresAlumno"],
        "apellidosAlumno" => $_POST["apellidosAlumno"],
        "sexoAlumno" => $_POST["sexoAlumno"],
        "estadoAlumno" => 3,
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
      $nuevoAlumno = ModelAlumnos::mdlCrearAlumno($tabla, $dataAlumno);

      if ($nuevoAlumno == "ok") {
        $listaApoderados = json_decode($_POST["listaApoderados"], true);
        //  Se obtiene la lista de apoderados, si es vacía o nula, solo se crea el alumno. Sino se crea cada apoderado.
        if ($listaApoderados != null || $listaApoderados != "") {
          $codAlumno = self::ctrObtenerUltimoAlumnoCreado();
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
              "idAlumno" => $codAlumno["idAlumno"],
              "idApoderado" => $codApoderado["idApoderado"],
              "fechaCreacion" => date("Y-m-d\TH:i:sP"),
              "fechaActualizacion" => date("Y-m-d\TH:i:sP"),
              "usuarioCreacion" => $_SESSION["idUsuario"],
              "usuarioActualizacion" => $_SESSION["idUsuario"]
            );
            $response = self::ctrAsignarAlumnoApoderado($dataApoderadoAlumno);
          }
          //  Le asignamos el grado del alumno
          $dataAlumnoGrado = array(
            "idAlumno" => $codAlumno["idAlumno"],
            "idGrado" => $_POST["gradoAlumno"],
            "estadoGradoAlumno" => 1,
            "fechaCreacion" => date("Y-m-d\TH:i:sP"),
            "fechaActualizacion" => date("Y-m-d\TH:i:sP"),
            "usuarioCreacion" => $_SESSION["idUsuario"],
            "usuarioActualizacion" => $_SESSION["idUsuario"]
          );
          ControllerGradoAlumno::ctrAsignarGradoAlumno($dataAlumnoGrado);
        } else {
          $response = "ok";
        }
        if ($response == "ok") {
          $mensaje = ControllerFunciones::mostrarAlerta("success", "Correcto", "Alumno Creado Correctamente", "listaAlumnos");
          echo $mensaje;
        } else {
          $mensaje = ControllerFunciones::mostrarAlerta("error", "Error", "Error Al Crear nuevo Alumno", "listaAlumnos");
          echo $mensaje;
        }
      } else {
        $mensaje = ControllerFunciones::mostrarAlerta("error", "Error", "Error Al Crear nuevo Alumno", "listaAlumnos");
        echo $mensaje;
      }
    }
  } */
  //  Obtener ultimo alumno creado
  public static function ctrObtenerUltimoAlumnoCreado()
  {
    $tabla = "alumno";
    $response = ModelAlumnos::mdlObtenerUltimoAlumnoCreado($tabla);
    return $response;
  }
  //  Asignar alumno a apoderado
  public static function ctrAsignarAlumnoApoderado($dataApoderadoAlumno)
  {
    $tabla = "apoderado_alumno";
    $response = ModelAlumnos::mdlAsignarAlumnoApoderado($tabla, $dataApoderadoAlumno);
    return $response;
  }
  //  crear postulante alumno admitido
  public static function ctrCrearAlumnoAdmision($codPostulanteEdit)
  {
    // Obtener al postulante por el código
    $table = "postulante";
    $dataPostulante = ModelAlumnos::mdlObtenerAlPostulante($table, $codPostulanteEdit);
    // Verificar si se obtuvo el postulante
    if ($dataPostulante) {
     
      // Crear el array de datos de la admisión
      $dataArrayAlumno = array(
        "estadoSiagie" => 1,
        "estadoAlumno" => 1,
        "estadoMatricula" => 1,
        "nombresAlumno" => $dataPostulante["nombrePostulante"],
        "apellidosAlumno" => $dataPostulante["apellidoPostulante"],
        "dniAlumno" => $dataPostulante["dniPostulante"],
        "fechaNacimiento" => $dataPostulante["fechaNacimiento"],
        "fechaCreacion" => date("Y-m-d H:i:s"),
        "fechaActualizacion" => date("Y-m-d H:i:s"),
        "usuarioCreacion" => $_SESSION["idUsuario"],
        "usuarioActualizacion" => $_SESSION["idUsuario"]
      );
      $table = "alumno";
      $result = ModelAlumnos::mdlCreatePostulateAlumno($table, $dataArrayAlumno);
      if ($result == "ok") {
        $ultimoRegistroIdAlumno = ModelAlumnos::mdlObtenerUltimoAlumnoCreado($table);
        // Devolver el ID del último registro de admisión creado y el grado del postulante
        return array(
          "idAlumno" => intval($ultimoRegistroIdAlumno),
          "idGrado" => intval($dataPostulante["gradoPostulacion"])
        );
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

}
