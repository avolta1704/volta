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
}
