<?php
date_default_timezone_set('America/Lima');
/* require_once "anioescolar.controller.php";
require_once "..model/anioescolar.model.php"; */
class ControllerAnioEscolar
{
  //  Crear nuevo Año Escolar
  public static function ctrCrearAnioEscolar($dataAnioEscolar)
  {
    $tabla = "anio_escolar";
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    $arrayAnio = array(
      "descripcionAnio" => "Año " . $dataAnioEscolar["descripcionAnio"],
      "estadoAnio" => "2",
      "cuotaInicial" => $dataAnioEscolar["cuotaIngreso"],
      "matriculaInicial" => $dataAnioEscolar["matriculaInicial"],
      "pensionInicial" => $dataAnioEscolar["pensionInicial"],
      "matriculaPrimaria" => $dataAnioEscolar["matriculaPrimaria"],
      "pensionPrimaria" => $dataAnioEscolar["pensionPrimaria"],
      "matriculaSecundaria" => $dataAnioEscolar["matriculaSecundaria"],
      "pensionSecundaria" => $dataAnioEscolar["pensionSecundaria"],
      "fechaCreacion" => date("Y-m-d H:i:s"),
      "fechaActualizacion" => date("Y-m-d H:i:s"),
      "usuarioCreacion" => $_SESSION["idUsuario"],
      "usuarioActualizacion" => $_SESSION["idUsuario"]
    );
    $response = ModelAnioEscolar::mdlCrearAnioEscolar($tabla, $arrayAnio);
    return $response;
  }
  //  Obtener el anio escolar por el estado activo = 1 // y admision extraordinario
  public static function ctrAnioEscolarActivoParaRegistroAlumno($estadoAnio)
  {
    $table = "anio_escolar";
    $listAnioEscolarActiva =  ModelAnioEscolar::mdlGetAnioEscolarEstadoActivo($table, $estadoAnio);
    return $listAnioEscolarActiva;
  }

  //  Obtener datos del anio escolar
  public static function ctrGetAnioEscolarActivo()
  {
    $table = "anio_escolar";
    $listAnioEscolarActiva =  ModelAnioEscolar::mdlGetAnioEscolarActivo($table);
    return $listAnioEscolarActiva;
  }

  //  Obtener todos los años escolares
  public static function ctrGetTodosAniosEscolar()
  {
    $table = "anio_escolar";
    $listaAnios = ModelAnioEscolar::mdlGetTodosAniosEscolar($table);
    return $listaAnios;
  }

  //  Obtener un año escolar para luego editarlo
  public static function ctrBuscarAnioEscolar($codAnio)
  {
    $table = "anio_escolar";
    $respuesta = ModelAnioEscolar::mdlBuscarAnioEscolar($table, $codAnio);
    $descripcionAnio = explode(" ", $respuesta['descripcionAnio']);
    $respuesta['descripcionAnio'] = $descripcionAnio[1];
    return $respuesta;
  }

  //  Editar un año escolar existente
  public static function ctrEditarAnioEscolar($dataEditarAnio)
  {
    $tabla = "anio_escolar";
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    $arrayAnio = array(
      "idAnioEscolar" => $dataEditarAnio["idAnioEscolar"],
      "descripcionAnio" => "Año " . $dataEditarAnio["descripcionAnio"],
      "cuotaInicial" => $dataEditarAnio["cuotaIngreso"],
      "matriculaInicial" => $dataEditarAnio["matriculaInicial"],
      "pensionInicial" => $dataEditarAnio["pensionInicial"],
      "matriculaPrimaria" => $dataEditarAnio["matriculaPrimaria"],
      "pensionPrimaria" => $dataEditarAnio["pensionPrimaria"],
      "matriculaSecundaria" => $dataEditarAnio["matriculaSecundaria"],
      "pensionSecundaria" => $dataEditarAnio["pensionSecundaria"],
      "fechaActualizacion" => date("Y-m-d H:i:s"),
      "usuarioActualizacion" => $_SESSION["idUsuario"]
    );
    $response = ModelAnioEscolar::mdlEditarAnioEscolar($tabla, $arrayAnio);
    return $response;
  }

  //  Activar o Desactivar año escolar
  public static function ctrActivarAnioEscolar($dataActivarAnioEscolar)
  {
    $tabla = "anio_escolar";
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    $nuevoEstado = $dataActivarAnioEscolar["estadoAnio"] == 1 ? 2 : 1;
    $arrayAnio = array(
      "idAnioEscolar" => $dataActivarAnioEscolar["codAnio"],
      "estadoAnio" => $nuevoEstado,
      "fechaActualizacion" => date("Y-m-d H:i:s"),
      "usuarioActualizacion" => $_SESSION["idUsuario"]
    );
    $response = ModelAnioEscolar::mdlActivarAnioEscolar($tabla, $arrayAnio);
    return $response;
  }

  //  Eliminar Año Escolar
  public static function ctrEliminarAnioEscolar($codAnioEliminar)
  {
    $tabla = "anio_escolar";
    $verificar = self::ctrVerificarUsoAnioEscolar($codAnioEliminar);
    if ($verificar["existencia"] == true || $verificar["existencia"] == "1") {
      return "error";
    } else {
      $response = ModelAnioEscolar::mdlEliminarAnioEscolar($tabla, $codAnioEliminar);
    }
    return $response;
  }

  //  Verificar el uso del año escolar
  public static function ctrVerificarUsoAnioEscolar($codAnio)
  {
    $response = ModelAnioEscolar::mdlVerificarUsoAnioEscolar($codAnio);
    return $response;
  }
  /**
   * Obtener el nivel de educacion
   * 
   * @param int $idNivelEducacion
   * @return string
   */

  public static function ctrGetNivelEducacion($idNivelEducacion)
  {
    $table = "nivel";
    $listNivelEducacion = ModelAnioEscolar::mdlGetNivelEducacion($table, $idNivelEducacion);
    return $listNivelEducacion;
  }
  public static function ctrMostrarGradosCerrarAnioEscolar()
  {
    $tabla =  "grado";
    $respuesta = ModelAnioEscolar::mdlMostrarGradosCerrarAnioEscolar($tabla);
    return $respuesta;
  }
  public static function ctrMostrarAlumnosGradoCerrarAnio($idGrado)
  {
    $tabla = "alumno";
    $respuesta = ModelAnioEscolar::mdlMostrarAlumnosGradoCerrarAnio($tabla, $idGrado);
    return $respuesta;
  }
  // Actualizar estado final Alumno
  public static function ctrActualizarEstadoFinalAlumnoAnioEscolarCerrarAnio($idGrado, $idAnioEscolar, $idAlumno, $estadoFinal)
  {
    $tabla = "alumno_anio_escolar";
    $respuesta = ModelAnioEscolar::mdlActualizarEstadoFinalAlumnoAnioEscolarCerrarAnio($tabla, $idGrado, $idAnioEscolar, $idAlumno, $estadoFinal);
    return $respuesta;
  }
  public static function ctrGetAlumnosMatriculadosGrado($tabla, $idGrado)
  {
    $respuesta = ModelAnioEscolar::mdlGetAlumnosMatriculadosGrado($tabla, $idGrado);
    return $respuesta;
  }
  // Validar Notas subidas correctamente del alumno
  public static function ctrValidarNotasAlumnosSubidosCorrectamenteCerrarAnioAlumno($idAlumno, $tabla)
  {
    $respuesta = ModelAnioEscolar::mdlValidacionNotasSubidasporAlumno($tabla, $idAlumno);
    return $respuesta;
  }
  // Validar Estado Final del alumno
  public static function ctrValidarEstadoFinalAlumnosSubidosCorrectamenteCerrarAnioAlumno($idAlumno, $tabla)
  {
    $respuesta = ModelAnioEscolar::mdlValidarEstadoFinalporAlumno($tabla, $idAlumno);
    return $respuesta;
  }
  // Validar si todos los alumnos del grado ya se les creo un alumno anio escolar con el grado al que van a pasar
  public static function ctrValidarFinAnioGradoAnioEscolar($idGrado)
  {
    $tabla = "alumno_anio_escolar";
    $respuesta = ModelAnioEscolar::mdlValidarFinAnioGradoAnioEscolar($tabla, $idGrado);
    return $respuesta;
  }
  public static function ctrActualizarFinAnioAlumnoAnioEscolarCerrarAnio($idGrado, $idAnioEscolar, $idAlumno, $finAnio)
  {
    $tabla = "alumno_anio_escolar";
    $respuesta = ModelAnioEscolar::mdlActualizarFinAnioAlumnoAnioEscolarCerrarAnio($tabla, $idGrado, $idAnioEscolar, $idAlumno, $finAnio);
    return $respuesta;
  }
  public static function ctrCerrarAnioEscolarFinalDesactivar()
  {
    $tabla = "anio_escolar";
    $respuesta = ModelAnioEscolar::mdlObtenerCantidadAniosActivos($tabla);
    if ($respuesta["CantidadAnios"] != 1) {
      return "Error Activos";
    } else {
      $tabla = "alumno_anio_escolar";
      $respuesta = ModelAnioEscolar::mdlValidarCierreGradoAlumnoFinAnio($tabla);
      if ($respuesta == "ok") {
        $idAnioEscolarElegido = ModelAnioEscolar::mdlObtenerIdAnioEscolarElegidoenCadaGrado($tabla);
        $table = "anio_escolar";
        $idAnioEscolarActivo = ModelAnioEscolar::mdlGetAnioEscolarActivo($table);
        if (session_status() == PHP_SESSION_NONE) {
          session_start();
        }
        $arrayAnioDesactivar = array(
          "idAnioEscolar" => $idAnioEscolarActivo["idAnioEscolar"],
          "estadoAnio" => 2,
          "fechaActualizacion" => date("Y-m-d H:i:s"),
          "usuarioActualizacion" => $_SESSION["idUsuario"]
        );
        $arrayAnioActivar = array(
          "idAnioEscolar" => $idAnioEscolarElegido["finAnio"],
          "estadoAnio" => 1,
          "fechaActualizacion" => date("Y-m-d H:i:s"),
          "usuarioActualizacion" => $_SESSION["idUsuario"]
        );
        $respuesta =  ModelAnioEscolar::mdlActivarAnioEscolar($table, $arrayAnioDesactivar);
        if ($respuesta == "ok") {
          $respuesta = ModelAnioEscolar::mdlActivarAnioEscolar($table, $arrayAnioActivar);
        }
      }
      return $respuesta;
    }
  }
}
