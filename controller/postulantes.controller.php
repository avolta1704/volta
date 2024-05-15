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
    if (isset($_POST["nombrePostulante"]) && isset($_POST["apellidoPostulante"]) && (($_POST["nombrePadre"]) || ($_POST["nombreMadre"]))) {
      $tabla = "postulante";
      //  Mandar datos de los padres
      $dataPadre = array(
        "nombreApoderado" => $_POST["nombrePadre"],
        "apellidoApoderado" => $_POST["apellidoPadre"],
        "dniApoderado" => $_POST["dniPadre"],
        "fechaNacimiento" => $_POST["fechaNacimientoPadre"],
        "convivenciaAlumno" => $_POST["convivePadre"],
        "tipoApoderado" => "Padre",
        "gradoInstruccion" => $_POST["gradoPadre"],
        "profesionApoderado" => $_POST["profesionPadre"],
        "correoApoderado" => $_POST["emailPadre"],
        "celularApoderado" => $_POST["numeroPadre"],
        "dependenciaApoderado" => $_POST["dependenciaPadre"],
        "centroLaboral" => $_POST["centroPadre"],
        "telefonoTrabajo" => $_POST["numeroTrabajoPadre"],
        "ingresoMensual" => $_POST["ingresoPadre"],
        "fechaCreacion" => date("Y-m-d H:i:s"),
        "fechaActualizacion" => date("Y-m-d H:i:s"),
        "usuarioCreacion" => $_SESSION["idUsuario"],
        "usuarioActualizacion" => $_SESSION["idUsuario"]
      );
      $response = ControllerApoderados::ctrCrearApoderado($dataPadre);
      $idPadre = ControllerApoderados::ctrObtenerUltimoApoderado();
      $dataMadre = array(
        "nombreApoderado" => $_POST["nombreMadre"],
        "apellidoApoderado" => $_POST["apellidoMadre"],
        "dniApoderado" => $_POST["dniMadre"],
        "fechaNacimiento" => $_POST["fechaNacimientoMadre"],
        "convivenciaAlumno" => $_POST["conviveMadre"],
        "tipoApoderado" => "Madre",
        "gradoInstruccion" => $_POST["gradoMadre"],
        "profesionApoderado" => $_POST["profesionMadre"],
        "correoApoderado" => $_POST["emailMadre"],
        "celularApoderado" => $_POST["numeroMadre"],
        "dependenciaApoderado" => $_POST["dependenciaMadre"],
        "centroLaboral" => $_POST["centroMadre"],
        "telefonoTrabajo" => $_POST["numeroTrabajoMadre"],
        "ingresoMensual" => $_POST["ingresoMadre"],
        "fechaCreacion" => date("Y-m-d H:i:s"),
        "fechaActualizacion" => date("Y-m-d H:i:s"),
        "usuarioCreacion" => $_SESSION["idUsuario"],
        "usuarioActualizacion" => $_SESSION["idUsuario"]
      );
      $response = ControllerApoderados::ctrCrearApoderado($dataMadre);
      $idMadre = ControllerApoderados::ctrObtenerUltimoApoderado();

      $listaApoderado = array(
        "idPadre" => $idPadre["idApoderado"],
        "idMadre" => $idMadre["idApoderado"]
      );
      $listaApoderado = json_encode($listaApoderado);

      if ($response == "ok") {
        $datosPostulante = array(
          "nombrePostulante" => $_POST["nombrePostulante"],
          "apellidoPostulante" => $_POST["apellidoPostulante"],
          "sexoPostulante" => $_POST["sexoPostulante"],
          "dniPostulante" => $_POST["dniPostulante"],
          "gradoPostulacion" => $_POST["gradoAlumno"],
          "fechaPostulacion" => $_POST["fechaPostulacion"],
          "fechaNacimiento" => $_POST["fechaNacimiento"],
          "lugarNacimiento" => $_POST["lugarNacimiento"],
          "domicilioPostulante" => $_POST["domicilioPostulante"],
          "colegioProcedencia" => $_POST["colegioProcedencia"],
          "dificultadPostulante" => $_POST["dificultadAprendizaje"],
          "dificultadObservacion" => $_POST["detalleDificultad"],
          "tipoAtencionPostulante" => $_POST["tipoSalud"],
          "tratamientoPostulante" => $_POST["tratamientoPostulante"],
          "listaApoderados" => $listaApoderado,
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
        "sexoPostulante" => $_POST["editarSexo"],
        "dniPostulante" => $_POST["editarDni"],
        "gradoPostulacion" => $_POST["gradoAlumno"],
        "fechaPostulacion" => $_POST["editarFechaPostulacion"],
        "fechaNacimiento" => $_POST["editarFechaNacimiento"],
        "lugarNacimiento" => $_POST["editarLugarNacimiento"],
        "domicilioPostulante" => $_POST["editarDomicilio"],
        "colegioProcedencia" => $_POST["editarColegioProced"],
        "dificultadPostulante" => $_POST["editarDificultad"],
        "dificultadObservacion" => $_POST["editarDetalleDif"],
        "tipoAtencionPostulante" => $_POST["editarTipoSalud"],
        "tratamientoPostulante" => $_POST["editarTratamiento"],
        "fechaActualizacion" => date("Y-m-d H:i:s"),
        "usuarioActualizacion" => $_SESSION["idUsuario"]
      );
      $response = ModelPostulantes::mdlEditarPostulante($tabla, $datosPostulante);
      if ($response == "ok") {
        $dataPadre = array(
          "idApoderado" => $_POST["codPadre"],
          "nombreApoderado" => $_POST["editarNombrePadre"],
          "apellidoApoderado" => $_POST["editarApellidoPadre"],
          "dniApoderado" => $_POST["editarDniPadre"],
          "fechaNacimiento" => $_POST["editarFechaPadre"],
          "convivenciaAlumno" => $_POST["editarConvivePadre"],
          "gradoInstruccion" => $_POST["editarGradoPadre"],
          "profesionApoderado" => $_POST["editarProfesionPadre"],
          "correoApoderado" => $_POST["editarCorreoPadre"],
          "celularApoderado" => $_POST["editarCelularPadre"],
          "dependenciaApoderado" => $_POST["editarDepenPadre"],
          "centroLaboral" => $_POST["editarCentroPadre"],
          "telefonoTrabajo" => $_POST["editarNumTrabajoPadre"],
          "ingresoMensual" => $_POST["editarIngresoPadre"],
          "fechaActualizacion" => date("Y-m-d H:i:s"),
          "usuarioActualizacion" => $_SESSION["idUsuario"]
        );
        $dataMadre = array(
          "idApoderado" => $_POST["codMadre"],
          "nombreApoderado" => $_POST["editarNombreMadre"],
          "apellidoApoderado" => $_POST["editarApellidoMadre"],
          "dniApoderado" => $_POST["editarDniMadre"],
          "fechaNacimiento" => $_POST["editarFechaMadre"],
          "convivenciaAlumno" => $_POST["editarConviveMadre"],
          "gradoInstruccion" => $_POST["editarGradoMadre"],
          "profesionApoderado" => $_POST["editarProfesionMadre"],
          "correoApoderado" => $_POST["editarCorreoMadre"],
          "celularApoderado" => $_POST["editarCelularMadre"],
          "dependenciaApoderado" => $_POST["editarDepenMadre"],
          "centroLaboral" => $_POST["editarCentroMadre"],
          "telefonoTrabajo" => $_POST["editarNumTrabajoMadre"],
          "ingresoMensual" => $_POST["editarIngresoMadre"],
          "fechaActualizacion" => date("Y-m-d H:i:s"),
          "usuarioActualizacion" => $_SESSION["idUsuario"]
        );

        //  Actualizar los datos de ambos apoderados
        $response = ControllerApoderados::ctrEditarApoderado($dataPadre);
        $response = ControllerApoderados::ctrEditarApoderado($dataMadre);
        if ($response == "ok") {
          $mensaje = ControllerFunciones::mostrarAlerta("success", "Correcto", "Postulante editado correctamente", "listaPostulantes");
          echo $mensaje;
        } else {
          $mensaje = ControllerFunciones::mostrarAlerta("error", "Error", "Error al editar el postulante", "listaPostulantes");
          echo $mensaje;
        }
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
    $listaApoderados = json_decode($dataPostulante["listaApoderados"], true);
    if ($listaApoderados["idPadre"] != null) {
      $dataPadre = ControllerApoderados::ctrGetApoderadoById($listaApoderados["idPadre"]);
      $dataPostulante["dataPadre"] = $dataPadre;
    }
    if ($listaApoderados["idMadre"] != null) {
      $dataMadre = ControllerApoderados::ctrGetApoderadoById($listaApoderados["idMadre"]);
      $dataPostulante["dataMadre"] = $dataMadre;
    }
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

    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }

    $dataPostulanteEdit = array(
      "idPostulante" => $codPostulanteEdit,
      "estadoPostulante" => $estadoPostulanteActual,
      "fechaActualizacion" => date("Y-m-d H:i:s"),
      "usuarioActualizacion" => $_SESSION["idUsuario"]
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
            $tipoAdmision = "Ordinario";
            $admisionAnioEscolar = ControllerAdmision::ctrAdmisionEscolarActivaRegistroPostulante($anioEscolarActiva, $codPostulanteEdit, $tipoAdmision);
            if ($admisionAnioEscolar != false) {
              // Crear un nuevo registro de alumno por la tabla postulante en la tabla admision_alumno
              $admisionAlumno = ControllerAdmisionAlumno::ctrCrearAdmisionAlumno($admisionAnioEscolar, $alumnoAdmision);
              //  Crear un nuevo registro de anio_admision en la tabla anio_admision 
              if ($admisionAlumno == "ok") {
                $ultimoAdmisionAlumno = ControllerAdmisionAlumno::ctrObtenerUltimoAdmisionAlumno();
                $anioAdmision = ControllerAnioAdmision::ctrCrearAnioAdmision($ultimoAdmisionAlumno["idAdmisionAlumno"], $anioEscolarActiva);
                if ($anioAdmision == "ok") {

                  $tablaPostulantes = "postulante";
                  // Verificar si el postulante ya pago la matricula
                  $isPagoMatricula = ModelPostulantes::mdlIsPostulantePagoMatricula($tablaPostulantes, $codPostulanteEdit);
                  if ($isPagoMatricula == "ok") {
                    // Crear el cronograma de pagos para el alumno
                    $cronogramaPago = ControllerAdmisionAlumno::ctrActualizarestadoAdmisionAlumno($ultimoAdmisionAlumno["idAdmisionAlumno"]);
                    if ($cronogramaPago == "ok") {
                      return "ok";
                    } else {
                      return "error";
                    }
                  }

                  //  Relacionar los apoderados con los alumnos
                  $listaApoderados = ControllerPostulantes::ctrGetListaApoderados($codPostulanteEdit);
                  $alumnoCreado = ControllerAlumnos::ctrGetUltimoAlumnoCreado();
                  $actualizarApoderados = ControllerApoderadoAlumno::ctrCrearApoderadoAlumno($listaApoderados[0], $alumnoCreado);
                  return $actualizarApoderados;
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

  //  Obtener datos de un postulante
  public static function  ctrGetDatosPostulantes($codPostulanteEdit)
  {
    $tabla = "postulante";
    $dataPostulante = ModelPostulantes::mdlGetDatosPostulanteEditar($tabla, $codPostulanteEdit);
    return $dataPostulante;
  }

  //  Obtener la lista de apoderados de un postulante
  public static function ctrGetListaApoderados($codPostulante)
  {
    $tabla = "postulante";
    $listaApoderados = ModelPostulantes::mdlGetListaApoderados($tabla, $codPostulante);
    return $listaApoderados;
  }

  //  Obtener los postulantes para el select
  public static function ctrGetPostulantesBusqueda()
  {
    $tabla = "postulante";
    $listaPostulantes = ModelPostulantes::mdlGetPostulantesBusqueda($tabla);
    return $listaPostulantes;
  }

  //  Buscar postulante por id
  public static function ctrBuscarPostulanteById($codPostulante)
  {
    $table = "postulante";
    $dataPostulante = ModelPostulantes::mdlBuscarPostulanteById($table, $codPostulante);
    $listaApoderados = json_decode($dataPostulante["listaApoderados"], true);
    foreach ($listaApoderados as $key => $value) {
      if ($value != null) {
        $dataApoderado = ControllerApoderados::ctrGetApoderadoById($value);
        $dataPostulante[$key] = $dataApoderado;
      }
    }
    return $dataPostulante;
  }
}
