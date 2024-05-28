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
    try {
      $tabla = "postulante";
      // Verificar si existe un pago de matricula para el postulante solo si el valor del estado es igual a 3 matriculado
      if ($estadoPostulanteEdit == 3) {
        $matriculaPostulanteActual = ModelPostulantes::mdlObtenerMatriculaPostulante($tabla, $codPostulanteEdit);
        // Verificar si existe un pago de matricula para el postulante
        if (empty($matriculaPostulanteActual["pagoMatricula"])) {
          // Si está vacío, devolver "error"
          return "error";
        }
      }
      // Verificar si el estado actual es igual al estado que se quiere actualizar
      $estadoPostulanteActual = ModelPostulantes::mdlObtenerEstadoPostulante($tabla, $codPostulanteEdit);

      // Verificar si el estado actual es igual al estado que se quiere actualizar
      if ($estadoPostulanteActual["estadoPostulante"] == $estadoPostulanteEdit) {
        // Si son iguales, lanzar una excepción
        throw new Exception("El estado actual ya es el estado deseado.");
      }

      // Iniciar la sesión si aún no se ha iniciado
      if (session_status() == PHP_SESSION_NONE) {
        session_start();
      }

      // Actualizar el estado del postulante en la base de datos
      $dataPostulanteEdit = array(
        "idPostulante" => $codPostulanteEdit,
        "estadoPostulante" => $estadoPostulanteEdit,
        "fechaActualizacion" => date("Y-m-d H:i:s"),
        "usuarioActualizacion" => $_SESSION["idUsuario"]
      );

      $actualizarEstado = ModelPostulantes::mdlActualizarEstadoPostulante($tabla, $dataPostulanteEdit);

      if ($actualizarEstado != "ok") {
        // Si hay un error al actualizar el estado, lanzar una excepción
        throw new Exception("Error al actualizar el estado del postulante.");
      }

      // Si el estado actual es igual a 3=aprobado, realizar operaciones adicionales
      if ($estadoPostulanteEdit == 3) {
        // Iniciar las funciones anidadas para crear un alumno
        $alumnoAdmision = ControllerAlumnos::ctrCrearAlumnoAdmision($codPostulanteEdit);

        if ($alumnoAdmision == false) {
          throw new Exception("Error al crear el alumno para la admisión.");
        }

        // Crear un nuevo registro del alumno creado en la tabla alumno_grado 
        $alumnoGradoAsignado = ControllerGradoAlumno::ctrRegistrarGradoAlumnoAdmision($alumnoAdmision);

        if (
          $alumnoGradoAsignado != "ok"
        ) {
          throw new Exception("Error al registrar el grado del alumno en la admisión.");
        }

        // Obtener el año escolar activo para el registro del postulante
        $anioEscolarActiva = ControllerAnioEscolar::ctrAnioEscolarActivoParaRegistroAlumno(1); // 1 para estadoAnio = 1

        if (!$anioEscolarActiva) {
          throw new Exception("No se encontró un año escolar activo para el registro del postulante.");
        }

        // Crear la admisión del postulante en el año escolar activo
        $admisionAnioEscolar = ControllerAdmision::ctrAdmisionEscolarActivaRegistroPostulante($anioEscolarActiva, $codPostulanteEdit, "Ordinario");

        if (!$admisionAnioEscolar) {
          throw new Exception("Error al crear la admisión del postulante.");
        }

        // Crear un nuevo registro de alumno por el postulante en la tabla admision_alumno
        $admisionAlumno = ControllerAdmisionAlumno::ctrCrearAdmisionAlumno($admisionAnioEscolar, $alumnoAdmision);

        if ($admisionAlumno != "ok") {
          throw new Exception("Error al crear el registro del alumno en la admisión.");
        }

        // Crear un nuevo registro de anio_admision en la tabla anio_admision 
        $ultimoAdmisionAlumno = ControllerAdmisionAlumno::ctrObtenerUltimoAdmisionAlumno();
        $anioAdmision = ControllerAnioAdmision::ctrCrearAnioAdmision($ultimoAdmisionAlumno["idAdmisionAlumno"], $anioEscolarActiva);

        if ($anioAdmision != "ok") {
          throw new Exception("Error al crear el registro del año de admisión.");
        }

        // Verificar si el postulante ya pagó la matrícula
        $tablaPostulantes = "postulante";
        $isPagoMatricula = ModelPostulantes::mdlIsPostulantePagoMatricula($tablaPostulantes, $codPostulanteEdit);

        if ($isPagoMatricula != "ok") {
          throw new Exception("El postulante no ha realizado el pago de matrícula.");
        }

        // Crear el cronograma de pagos para el alumno
        $cronogramaPago = ControllerAdmisionAlumno::ctrActualizarestadoAdmisionAlumnoCancelado($ultimoAdmisionAlumno["idAdmisionAlumno"]);

        if ($cronogramaPago != "ok") {
          throw new Exception("Error al crear el cronograma de pagos para el alumno.");
        }

        // TODO: Actualizar el pago para que tenga el ID del cronograma del pago y, además, en el cronograma de pago se actualice el estado a pagado
        $pagoMatricula = self::ctrGetPagoMatriculaPostulante($codPostulanteEdit);

        if ($pagoMatricula == null) {
          throw new Exception("Error al obtener el pago de matrícula del postulante.");
        }

        $codAdmision = ControllerAdmision::ctrGetCodAdmisionByPostulante($codPostulanteEdit);

        if ($codAdmision == null) {
          throw new Exception("Error al obtener el código de admisión del postulante.");
        }

        $codAdmisionAlumno = ControllerAdmisionAlumno::ctrGetCodAdmisionAlumnoByAdmision($codAdmision);

        if (
          $codAdmisionAlumno == null
        ) {
          throw new Exception("Error al obtener el código de admisión del alumno.");
        }

        $codCronogramaPago = ControllerAdmisionAlumno::ctrGetCodeCronogramaMatriculaByCodAdmisionAlumno($codAdmisionAlumno);

        if (
          $codCronogramaPago == null
        ) {
          throw new Exception("Error al obtener el código de cronograma de pago.");
        }

        $actualizarPagoMatriculaCodCronograma = array(
          "idPago" => $pagoMatricula["pagoMatricula"],
          "idCronogramaPago" => $codCronogramaPago,
          "fechaActualizacion" => date("Y-m-d H:i:s"),
          "usuarioActualizacion" => $_SESSION["idUsuario"]
        );

        $response = ControllerPagos::ctrActualizarIdCronogramaPagoMatricula($actualizarPagoMatriculaCodCronograma);

        if ($response != "ok") {
          throw new Exception("Error al actualizar el ID del cronograma de pago de la matrícula.");
        }

        $codCronogramaCuotaInicial = ControllerAdmisionAlumno::ctrGetCodeCronogramaCuotaInicialByCodAdmisionAlumno($codAdmisionAlumno);

        if (
          $codCronogramaCuotaInicial == null
        ) {
          throw new Exception("Error al obtener el código de cronograma de pago.");
        }

        $actualizarPagoCuotaInicialCodCronograma = array(
          "idPago" => $pagoMatricula["pagoCuotaIngreso"],
          "idCronogramaPago" => $codCronogramaCuotaInicial,
          "fechaActualizacion" => date("Y-m-d H:i:s"),
          "usuarioActualizacion" => $_SESSION["idUsuario"]
        );

        $response = ControllerPagos::ctrActualizarIdCronogramaPagoMatricula($actualizarPagoCuotaInicialCodCronograma);

        if ($response != "ok") {
          throw new Exception("Error al actualizar el ID del cronograma de pago de la matrícula.");
        }
      }

      // Commit de la transacción si todas las operaciones son exitosas
      return "ok";
    } catch (Exception $e) {
      // Si ocurre un error, hacer rollback de la transacción y devolver el mensaje de error
      return "error: " . $e->getMessage();
    }
  }


  //  Obtener datos de un postulante
  public static function ctrGetDatosPostulantes($codPostulanteEdit)
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

  /**
   * Obtiene el pago de matrícula de un postulante.
   *
   * @param int $codPostulante El código del postulante.
   * @return mixed El pago de matrícula del postulante.
   */
  public static function ctrGetPagoMatriculaPostulante($codPostulante)
  {
    $tabla = "postulante";
    $response = ModelPostulantes::mdlGetPagoMatriculaPostulante($tabla, $codPostulante);
    return $response;
  }

  //  Obtener el checklist del postulante
  public static function ctrGetChecklistPostulante($codPostulante)
  {
    $table = "postulante";
    $dataChecklist = ModelPostulantes::mdlGetChecklistPostulante($table, $codPostulante);
    return $dataChecklist;
  }


  //  Actualizar el checklist del postulante
  public static function ctrActualizarChecklist($dataActualizarcheclist)
  {
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }



    $table = "postulante";
    $dataChecklist = json_decode($dataActualizarcheclist, true); // Convierte la cadena JSON en un array

    $actualizarChecklist = array(
      "idPostulante" => $dataChecklist["codPostulanteCheck"],
      "estadoFichaPostulante" => $dataChecklist["checkFichaPostulante"] == "on" ? 1 : ($dataChecklist["checkFichaPostulante"] == "" ? 2 : 0), //Entero
      "fechaFichaPost" => $dataChecklist["fechaFichaPostulante"] != "" ? $dataChecklist["fechaFichaPostulante"] : null,
      "fechaEntrevista" => $dataChecklist["fechaEntrevista"] != "" ? $dataChecklist["fechaEntrevista"] : "",
      "estadoEntrevista" => $dataChecklist["checkEntrevista"] == "on" ? 1 : ($dataChecklist["checkEntrevista"] == "" ? 0 : 0),
      "fechaInformePsicologico" => $dataChecklist["fechaInformePsico"] != "" ? $dataChecklist["fechaEntrevista"] : "",
      "estadoInformePsicologico" => $dataChecklist["checkInformePsico"] == "on" ? 1 : ($dataChecklist["checkInformePsico"] == "" ? 2 : 0),
      "constanciaAdeudo" => $dataChecklist["checkConstAdeudo"] == "on" ? true : false,
      "fechaConstanciaAdeudo" => $dataChecklist["fechaConstAdeudo"] != "" ? $dataChecklist["fechaConstAdeudo"] : "",
      "cartaAdmision" => $dataChecklist["checkCartaAdmision"] == "on" ? true : false,
      "fechaCartaAdmision" => $dataChecklist["fechaCartaAdmision"] != "" ? $dataChecklist["fechaCartaAdmision"] : "",
      "contrato" => $dataChecklist["checkContrato"] == "on" ? true : false,
      "fechaContrato" => $dataChecklist["fechaContrato"] != "" ? $dataChecklist["fechaContrato"] : "",
      "constanciaVacante" => $dataChecklist["checkConstVacante"] == "on" ? true : false,
      "fechaConstanciaVacante" => $dataChecklist["fechaConstVacante"] != "" ? $dataChecklist["fechaConstVacante"] : "0000-00-00",
      //"pagoMatricula" => $dataChecklist["checkPagoMatricula"] == "on" ? 1 : ($dataChecklist["checkPagoMatricula"] == "" ? 0 : 0),
      "fechaPagoMatricula" => $dataChecklist["fechaPagoMatricula"] != "" ? $dataChecklist["fechaPagoMatricula"] : "0000-00-00",
      "fechaActualizacion" => date("Y-m-d H:i:s"),
      "usuarioActualizacion" => $_SESSION["idUsuario"],
      "documentoTraslado" => $dataChecklist["checkDocumentoTraslado"] == "on" ? true : false,
      "fechaDocumentoTraslado" => $dataChecklist["fechaDocumentoTraslado"] != "" ? $dataChecklist["fechaDocumentoTraslado"] : "",
    );

    $response = ModelPostulantes::mdlActualizarChecklist($table, $actualizarChecklist);
    return $response;
  }

  //  Subir el downloadURL del postulante
  public static function ctrObtenerDownloadURL($obtenerDownloadURL, $codPostulanteUrl)
  {
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }

    $table = "postulante";
    $dataChecklist = array(
      "idPostulante" => $codPostulanteUrl,
      "fichaPostulante" => $obtenerDownloadURL,
      "fechaActualizacion" => date("Y-m-d H:i:s"),
      "usuarioActualizacion" => $_SESSION["idUsuario"]
    );
    $response = ModelPostulantes::mdlObtenerDownloadURL($table, $dataChecklist);
    return $response;
  }

  //  Obtener el URL del postulante
  public static function ctrDownloadURL($codPostulanteUrl)
  {
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }

    $table = "postulante";
    $response = ModelPostulantes::mdlDownloadURL($table, $codPostulanteUrl);
    return $response;
  }

  //  Subir el downloadURL psicologico del postulante
  public static function ctrObtenerDownloadURLPsicologico($obtenerDownloadURLPsicologico, $codPostulanteUrlPsicologico)
  {
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }

    $table = "postulante";
    $dataChecklist = array(
      "idPostulante" => $codPostulanteUrlPsicologico,
      "informePsicologico" => $obtenerDownloadURLPsicologico,
      "fechaActualizacion" => date("Y-m-d H:i:s"),
      "usuarioActualizacion" => $_SESSION["idUsuario"]
    );
    $response = ModelPostulantes::mdlObtenerDownloadURLPsicologico($table, $dataChecklist);
    return $response;
  }
  //  Obtener el URL psicologico del postulante
  public static function ctrDownloadURLPsicologico($codPostulanteUrlPsicologico)
  {
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }

    $table = "postulante";
    $response = ModelPostulantes::mdlDownloadURLPsicologico($table, $codPostulanteUrlPsicologico);
    return $response;
  }

  //  Obtener datos del Pago para editar 
  public static function ctrGetIdEditPago($codPago)
  {
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    $tabla = "pago";
    $dataPago = ModelPostulantes::mdlGetIdEditPago($tabla, $codPago);
    return $dataPago;
  }


  //  Obtener todos los postulantesRepostesAnio
  public static function ctrGetAllPostulantesReportesAnio()
  {
    $tabla = "postulante";
    $listPostulantes = ModelPostulantes::mdlGetAllPostulantes($tabla);
    return $listPostulantes;
  }
  // todos los Registros postulantes para el reporte xls
  public static function ctrGetAllRegistrosPostulantesReport($datos)
  {
    $tabla = "postulante";


    if (count($datos) <= 1) {
      // Si solo hay un dato inicia la funcion para recuperar datos,
      $listPostulantes = ModelPostulantes::mdlGetAllRegistrosPostulantesReport($tabla);
    } else if (isset($datos['anioInicio']) && isset($datos['anioFin'])) {
      // Si los datos contienen años específicos
      $listPostulantes = ModelPostulantes::mdlGetFechasAniosRegistrosPostulantesReport($tabla, $datos);
    } else if (isset($datos['fechaInicio']) && isset($datos['fechaFin'])) {
      // Si los datos contienen fechas específicas
      $listPostulantes = ModelPostulantes::mdlGetFechasMesesRegistrosPostulantesReport($tabla, $datos);
    }
    foreach ($listPostulantes as &$postulantesReportAnio) {
      //cabecera del reporte
      $ordenClaves = array('CODIGO', 'APELLIDOS Y NOMBRES', 'GRADO', 'FECHA POST', 'FICHA POSTULANTE', 'FECHA ENTRE', 'FICHA ENTREVISTA', 'FECHA PSI', 'INFORME PSICOLOGICO', 'FECHA CONS', 'CONSTANCIA NO ADEUDO', 'FECHA AD', 'CARTA ADMISION', 'FECHA MAT', 'PAGO MATRICULA', 'FECHA CONT', 'CONTRATO', 'FECHA VAC', 'CONSTANCIA VACANTE', 'FECHA DOC TRASLADO', 'DOC TRASLADO', 'OBSEVACIONES');

      $postulantesReportAnio['CODIGO'] = FunctionPostulantes::getUnirIdentificadorFechaPostulacionAnio($postulantesReportAnio["idPostulante"], $postulantesReportAnio["fechaPostulacion"]);
      $postulantesReportAnio['APELLIDOS Y NOMBRES'] = FunctionPostulantes::getUnirNombreApellidoPostulantesXls($postulantesReportAnio["nombrePostulante"], $postulantesReportAnio["apellidoPostulante"]);
      $postulantesReportAnio['GRADO'] = $postulantesReportAnio["descripcionGrado"];
      //ficha
      $postulantesReportAnio['FECHA POST'] = $postulantesReportAnio["fechaFichaPost"] != "" ? ($postulantesReportAnio["fechaFichaPost"] == "0000-00-00" ? "" : $postulantesReportAnio["fechaFichaPost"]) : "";
      $postulantesReportAnio['FICHA POSTULANTE'] = $postulantesReportAnio["estadoFichaPostulante"] ? "Listo" : "Falta";
      //entrevista
      $postulantesReportAnio['FECHA ENTRE'] = $postulantesReportAnio["fechaEntrevista"] != "" ? ($postulantesReportAnio["fechaFichaPost"] == "0000-00-00" ? "" : $postulantesReportAnio["fechaFichaPost"]) : "";
      $postulantesReportAnio['FICHA ENTREVISTA'] = $postulantesReportAnio["estadoEntrevista"] ? "Listo" : "Falta";
      //psicologico
      $postulantesReportAnio['FECHA PSI'] = $postulantesReportAnio["fechaInformePsicologico"] != "" ? ($postulantesReportAnio["fechaInformePsicologico"] == "0000-00-00" ? "" : $postulantesReportAnio["fechaInformePsicologico"]) : "";
      $postulantesReportAnio['INFORME PSICOLOGICO'] = $postulantesReportAnio["estadoInformePsicologico"] ? "Listo" : "Falta";
      //costancia no adeudo
      $postulantesReportAnio['FECHA CONS'] = $postulantesReportAnio["fechaConstanciaAdeudo"] != "" ? ($postulantesReportAnio["fechaInformePsicologico"] == "0000-00-00" ? "" : $postulantesReportAnio["fechaInformePsicologico"]) : "";
      $postulantesReportAnio['CONSTANCIA NO ADEUDO'] = $postulantesReportAnio["constanciaAdeudo"] ? "Listo" : "Falta";
      //carta admision
      $postulantesReportAnio['FECHA AD'] = $postulantesReportAnio["fechaCartaAdmision"] != "" ? ($postulantesReportAnio["fechaCartaAdmision"] == "0000-00-00" ? "" : $postulantesReportAnio["fechaCartaAdmision"]) : "";
      $postulantesReportAnio['CARTA ADMISION'] = $postulantesReportAnio["cartaAdmision"] ? "Listo" : "Falta";
      //pago matricula
      $postulantesReportAnio['FECHA MAT'] = $postulantesReportAnio["fechaPagoMatricula"] != "" ? ($postulantesReportAnio["fechaPagoMatricula"] == "0000-00-00" ? "" : $postulantesReportAnio["fechaPagoMatricula"]) : "";
      $postulantesReportAnio['PAGO MATRICULA'] = $postulantesReportAnio["pagoMatricula"] ? "Listo" : "Falta";
      //contrato
      $postulantesReportAnio['FECHA CONT'] = $postulantesReportAnio["fechaContrato"] != "" ? ($postulantesReportAnio["fechaContrato"] == "0000-00-00" ? "" : $postulantesReportAnio["fechaContrato"]) : "";
      $postulantesReportAnio['CONTRATO'] = $postulantesReportAnio["contrato"] ? "Listo" : "Falta";
      //constancia vacante
      $postulantesReportAnio['FECHA VAC'] = $postulantesReportAnio["fechaConstanciaVacante"] != "" ? ($postulantesReportAnio["fechaConstanciaVacante"] == "0000-00-00" ? "" : $postulantesReportAnio["fechaConstanciaVacante"]) : "";
      $postulantesReportAnio['CONSTANCIA VACANTE'] = $postulantesReportAnio["constanciaVacante"] ? "Listo" : "Falta";
      //documento traslado
      $postulantesReportAnio['FECHA DOC TRASLADO'] = $postulantesReportAnio["fechaDocumentoTraslado"] != "" ? ($postulantesReportAnio["fechaDocumentoTraslado"] == "0000-00-00" ? "" : $postulantesReportAnio["fechaDocumentoTraslado"]) : "";
      $postulantesReportAnio['DOC TRASLADO'] = $postulantesReportAnio["documentoTraslado"] ? "Listo" : "Falta";
      $postulantesReportAnio['OBSEVACIONES'] = "Observacion";
      // Eliminar los campos nombrePostulante y apellidoPostulante y gradoPostulante despues de usarlos
      unset($postulantesReportAnio["nombrePostulante"]);
      unset($postulantesReportAnio["apellidoPostulante"]);
      unset($postulantesReportAnio["fechaPostulacion"]);
      unset($postulantesReportAnio["descripcionGrado"]);
      unset($postulantesReportAnio["fechaEntrevista"]);
      unset($postulantesReportAnio["idPostulante"]);
      unset($postulantesReportAnio["fechaFichaPost"]);
      unset($postulantesReportAnio["estadoFichaPostulante"]);
      unset($postulantesReportAnio["estadoEntrevista"]);
      unset($postulantesReportAnio["fechaInformePsicologico"]);
      unset($postulantesReportAnio["estadoInformePsicologico"]);
      unset($postulantesReportAnio["fechaConstanciaAdeudo"]);
      unset($postulantesReportAnio["fechaCartaAdmision"]);
      unset($postulantesReportAnio["cartaAdmision"]);
      unset($postulantesReportAnio["fechaPagoMatricula"]);
      unset($postulantesReportAnio["pagoMatricula"]);
      unset($postulantesReportAnio["fechaContrato"]);
      unset($postulantesReportAnio["contrato"]);
      unset($postulantesReportAnio["fechaConstanciaVacante"]);
      unset($postulantesReportAnio["constanciaVacante"]);
      unset($postulantesReportAnio["constanciaAdeudo"]);
      unset($postulantesReportAnio["fechaDocumentoTraslado"]);
      unset($postulantesReportAnio["documentoTraslado"]);
      // Reordenar las claves del array para la cebezera del reporte
      $postulantesReportAnio = array_merge(array_flip($ordenClaves), $postulantesReportAnio);
    }
    return $listPostulantes;
  }
}
