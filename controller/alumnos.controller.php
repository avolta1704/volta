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
  // Obtener estadoAdmisionAlumno por idAdmisionAlumno
  public static function ctrGetEstadoAdmisionAlumnoAnioEscolar($idAdmisionAlumno)
  {
    $tabla = "admision_alumno";
    $response = ModelAlumnos::mdlGetEstadoAdmisionAlumnoAnioEscolar($tabla, $idAdmisionAlumno);
    return $response;
  }

  /**
   * Método para obtener los alumnos de un año escolar.
   * 
   * @param int $idAnioEscolar ID del año escolar.
   * @return array $response Array con los alumnos de un año escolar.
   */
  public static function ctrGetAlumnosAnioEscolar($idAnioEscolar)
  {
    $tabla = "alumno";
    $response = ModelAlumnos::mdlGetAlumnosAnioEscolar($tabla, $idAnioEscolar);
    return $response;
  }

  //  Obtener ultimo alumno creado
  public static function ctrObtenerUltimoAlumnoCreado()
  {
    $tabla = "alumno";
    $response = ModelAlumnos::mdlObtenerUltimoAlumnoCreado($tabla);
    return $response;
  }

  /**
   * Método para asignar un apoderado a un alumno, añade al padre como a la madre.
   * 
   * @param int $codAlumno ID del alumno.
   * @param string $listaApoderados JSON con los datos de los apoderados.
   * @return string $response Respuesta de la consulta.
   */
  public static function ctrAsignarAlumnoApoderado($codAlumno, $listaApoderados)
  {
    $tabla = "apoderado_alumno";
    $listaApoderados = json_decode($listaApoderados, true);
    $dataAlumno = array(
      "idAlumno" => $codAlumno,
      "idApoderado" => $listaApoderados["idPadre"],
      "fechaCreacion" => date("Y-m-d H:i:s"),
      "fechaActualizacion" => date("Y-m-d H:i:s"),
      "usuarioCreacion" => $_SESSION["idUsuario"],
      "usuarioActualizacion" => $_SESSION["idUsuario"]
    );
    $response = ModelAlumnos::mdlAsignarAlumnoApoderado($tabla, $dataAlumno);
    $dataAlumno["idApoderado"] = $listaApoderados["idMadre"];
    $response = ModelAlumnos::mdlAsignarAlumnoApoderado($tabla, $dataAlumno);
    return $response;
  }
  //  crear postulante alumno admitido
  public static function ctrCrearAlumnoAdmision($codPostulante)
  {
    // Obtener al postulante por el código
    $dataPostulante = ControllerPostulantes::ctrGetDatosPostulantes($codPostulante);

    // Verificar si se obtuvo el postulante
    if ($dataPostulante) {
      // Crear el array de datos de la admisión
      $dataArrayAlumno = array(
        "estadoSiagie" => 1,
        "nombresAlumno" => $dataPostulante["nombrePostulante"],
        "apellidosAlumno" => $dataPostulante["apellidoPostulante"],
        "dniAlumno" => $dataPostulante["dniPostulante"],
        "fechaNacimiento" => $dataPostulante["fechaNacimiento"],
        "sexoAlumno" => $dataPostulante["sexoPostulante"],
        "direccionAlumno" => $dataPostulante["domicilioPostulante"],
        "IEPProcedencia" => $dataPostulante["colegioProcedencia"],
        "seguroSalud" => $dataPostulante["tipoAtencionPostulante"],
        "fechaIngresoVolta" => date("Y-m-d H:i:s"),
        "nuevoAlumno" => 1,
        "enfermedades" => $dataPostulante["dificultadObservacion"],
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

  //  Obtener datos de un alumno
  public static function ctrGetDatosAlumnoEditar($codAlumno)
  {
    $tabla = "alumno";
    $response = ModelAlumnos::mdlGetDatosAlumnoEditar($tabla, $codAlumno);
    return $response;
  }

  //  Editar datos del alumno
  public static function ctrEditarAlumno()
  {
    if (isset($_POST["codAlumno"]) && isset($_POST["editarDniAlumno"])) {
      $tabla = "alumno";
      $data = array(
        "idAlumno" => $_POST["codAlumno"],
        "nombresAlumno" => $_POST["editarNombreAlumno"],
        "apellidosAlumno" => $_POST["editarApellidoAlumno"],
        "codAlumnoCaja" => $_POST["editarCodigoCaja"],
        "dniAlumno" => $_POST["editarDniAlumno"],
        "fechaNacimiento" => $_POST["editarFechaNacimiento"],
        "sexoAlumno" => $_POST["editarSexoAlumno"],
        "direccionAlumno" => $_POST["editarDireccionAlumno"],
        "distritoAlumno" => $_POST["editarDistritoAlumno"],
        "IEPProcedencia" => $_POST["editarIEPProcedencia"],
        "seguroSalud" => $_POST["editarSeguroSalud"],
        "fechaIngresoVolta" => $_POST["editarFechaIngreso"],
        "numeroEmergencia" => $_POST["editarNumeroEmergencia"],
        "enfermedades" => $_POST["editarEnfermedades"],
        "fechaActualizacion" => date("Y-m-d H:i:s"),
        "usuarioActualizacion" => $_SESSION["idUsuario"]
      );
      $response = ModelAlumnos::mdlEditarAlumno($tabla, $data);
      if ($response == "ok") {
        $mensaje = ControllerFunciones::mostrarAlerta("success", "Correcto", "Alumno editado correctamente", "listaAlumnos");
        echo $mensaje;
      } else {
        $mensaje = ControllerFunciones::mostrarAlerta("error", "Error", "Error al editar el alumno", "listaAlumnos");
        echo $mensaje;
      }
    }
  }

  //  Obtener el último alumno creado
  public static function ctrGetUltimoAlumnoCreado()
  {
    $tabla = "alumno";
    $response = ModelAlumnos::mdlGetUltimoAlumnoCreado($tabla);
    return $response;
  }

  //  Obtener los alumnos para busar mediante el select2 de la vista de pagos
  public static function ctrGetAlumnosPago()
  {
    $tabla = "alumno";
    $response = ModelAlumnos::mdlGetAlumnosPago($tabla);
    return $response;
  }

  //  Obtener la data de un alumno
  public static function ctrGetDataAlumnoPago($codAlumno)
  {
    $tabla = "alumno";
    $dataAlumno = ModelAlumnos::mdlGetDataAlumnoPago($tabla, $codAlumno);
    $calendariopagos = ControllerAdmisionAlumno::ctrGetCalendarioPagos($dataAlumno["idAdmisionAlumno"]);
    $dataAlumno["calendario"] = $calendariopagos;
    return $dataAlumno;
  }

  // TODO : Ya no existe esta funcionalidad en la vista
  //  Cambiar estado del alumno
  public static function ctrCambiarEstadoAlumno($codAlumno, $cambiarEstadoAlumno)
  {
    $tabla = "alumno";
    $dataAlumno = ModelAlumnos::mdlCambiarEstadoAlumno($tabla, $codAlumno, $cambiarEstadoAlumno);
    return $dataAlumno;
  }

  /**
   * Método para mostrar todos los alumnos de un curso.
   * 
   * @return array $response Array con los alumnos de un curso.
   */
  public static function ctrGetAlumnosCurso($idCurso, $idGrado, $idPersonal)
  {
    $tabla = "alumno";
    $response = ModelAlumnos::mdlGetAlumnosCurso($tabla, $idCurso, $idGrado, $idPersonal);
    return $response;
  }

  public static function ctrGetAlumnosCursoNotas($idCurso, $idGrado, $idPersonal, $idBimestre, $idUnidad)
  {
    $tabla = "alumno";
    $response = ModelAlumnos::mdlGetAlumnosCursoNotas($tabla, $idCurso, $idGrado, $idPersonal, $idBimestre, $idUnidad);
    return $response;
  }

  /**
   * Método para obtener los datos de un alumno por su ID.
   * 
   * @param int $idAlumno ID del alumno.
   * @return array $response Array con los datos del alumno.
   */
  public static function ctrGetAlumnoById($idAlumno)
  {
    $tabla = "alumno";
    $response = ModelAlumnos::mdlGetAlumnoById($tabla, $idAlumno);
    return $response;
  }
  /**
   * funcion para mostrar los datos de alumno.
   * @param int $idAlumno ID del alumno.
   * @return array $response Array de datos con los datos de alumno.
   */
  public static function ctrMostrarDatosAlumno($idAlumno)
  {
    $tabla = "alumno";
    $datosAlumno = ModelAlumnos::mdlMostrarDatosAlumno($tabla, $idAlumno);
    // combinar los dos arrays
    return $datosAlumno;
  }

  /**
   * Método para obtener los datos de un alumno por su ID para visualizar.
   * 
   * @param int $codAdmisionAlumno ID del alumno.
   */
  public static function ctrGetDatosVisualizar($codAdmisionAlumno)
  {
    $tabla = "alumno";
    $response = ModelAlumnos::mdlGetDatosVisualizar($tabla, $codAdmisionAlumno);
    return $response;
  }

  /**
   * Método para obtener los datos de un alumno por su idAlumnoAnioEscolar
   * 
   * @param int $idAlumnoAnioEscolar ID del alumno en el año escolar.
   * @return array $response Array con los datos del alumno.
   */
  public static function ctrGetAlumnoByIdAnioEscolar($idAlumnoAnioEscolar)
  {
    $tabla = "alumno";
    $response = ModelAlumnos::mdlGetAlumnoByIdAnioEscolar($tabla, $idAlumnoAnioEscolar);
    return $response;
  }
  public static function ctrGetAlumnoByIdAlumnoDocenteVisualizar($idAlumno){
    $tabla = "alumno";
    $response = ModelAlumnos::mdlGetAlumnoByIdAlumnoDocenteVisualizar($tabla, $idAlumno);
    return $response;
  }
  public static function ctrObtenerTodosIdAlumnoIdApoderadoHermanos(){
    $tabla = "alumno";
    $response = ModelAlumnos::mdlObtenerTodosIdAlumnoIdApoderadoHermanos($tabla);
    return $response;
  }
}
