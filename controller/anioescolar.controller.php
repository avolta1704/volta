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
    $arrayDatos = array(
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
    $response = ModelAnioEscolar::mdlCrearAnioEscolar($tabla, $arrayDatos);
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
}
