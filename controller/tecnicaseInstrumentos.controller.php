<?php
date_default_timezone_set('America/Lima');

class ControllerTecnicaseInstrumentos
{
  /**
   * Crear una nueva técnica e instrumento
   *
   * @param array $dataRegistrarTecnica
   * @return bool
   */
  public static function ctrCrearTecnicaeInstrumentos($dataRegistrarTecnica)
  {
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    $tabla = "tecnica_evaluacion";
    $dataTecnica = array(
      "descripcionTecnica" => $dataRegistrarTecnica["descripcionTecnica"],
      "codTecnica" => $dataRegistrarTecnica["codigoTecnica"],
      "fechaCreacion" => date("Y-m-d H:i:s"),
      "fechaActualizacion" => date("Y-m-d H:i:s"),
      "usuarioCreacion" => $_SESSION["idUsuario"],
      "usuarioActualizacion" => $_SESSION["idUsuario"]
    );
    $respuesta = ModelTecnicaseInstrumentos::mdlCrearTecnicaeInstrumentos($tabla, $dataTecnica);
    if ($respuesta) {
      $listaInstrumentos = json_decode($dataRegistrarTecnica["listaInstrumentosPorTecnica"], true);
      //  Obtener el último id de la técnica y crear el instrumento
      $idTecnica = ModelTecnicaseInstrumentos::mdlObtenerUltimoIdTecnica($tabla);
      $tabla = "instrumento";
      foreach ($listaInstrumentos as $instrumento) {
        $dataInstrumento = array(
          "idTecnicaEvaluacion" => $idTecnica,
          "descripcionInstrumento" => $instrumento["descripcion"],
          "codInstrumento" => $instrumento["codigo"],
          "fechaCreacion" => date("Y-m-d H:i:s"),
          "fechaActualizacion" => date("Y-m-d H:i:s"),
          "usuarioCreacion" => $_SESSION["idUsuario"],
          "usuarioActualizacion" => $_SESSION["idUsuario"]
        );
        $respuesta = ModelTecnicaseInstrumentos::mdlCrearInstrumento($tabla, $dataInstrumento);
      }
    }
    return $respuesta;
  }

  /**
   * Obtener todas las técnicas
   *
   * @return array
   */
  public static function ctrGetTodasLasTecnicas()
  {
    $tabla = "tecnica_evaluacion";
    $respuesta = ModelTecnicaseInstrumentos::mdlGetTodasLasTecnicas($tabla);
    return $respuesta;
  }

  /**
   * Visualizar una técnica
   *
   * @param string $codTecnicaVisualizar
   * @return array
   */
  public static function ctrVisualizarTecnica($codTecnicaVisualizar)
  {
    $tabla = "tecnica_evaluacion";
    $dataTecnica = ModelTecnicaseInstrumentos::mdlVisualizarTecnica($tabla, $codTecnicaVisualizar);
    $tabla = "instrumento";
    //  Obtener la lista de instrumentos por técnica
    $listaInstrumentos = ModelTecnicaseInstrumentos::mdlObtenerInstrumentos($tabla, $codTecnicaVisualizar);
    $dataTecnica["listaInstrumentos"] = json_encode($listaInstrumentos);
    return $dataTecnica;
  }

  /**
   * Eliminar un instrumento
   *
   * @param string $codInstrumento
   * @return bool
   */
  public static function ctrEliminarInstrumento($codInstrumento)
  {
    $tabla = "instrumento";
    $respuesta = ModelTecnicaseInstrumentos::mdlEliminarInstrumento($tabla, $codInstrumento);
    return $respuesta;
  }

  /**
   * Editar un instrumento
   *
   * @param string $dataTecnica
   * @return string
   */
  public static function ctrEditarInstrumento($dataTecnica)
  {
    $tabla = "tecnica_evaluacion";
    $dataTecnica = json_decode($dataTecnica, true);
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    $dataEditar = array(
      "idTecnicaEvaluacion" => $dataTecnica["idTecnica"],
      "descripcionTecnica" => $dataTecnica["descripcionTecnica"],
      "codTecnica" => $dataTecnica["codigoTecnica"],
      "fechaActualizacion" => date("Y-m-d H:i:s"),
      "usuarioActualizacion" => $_SESSION["idUsuario"]
    );
    $responseTenica = ModelTecnicaseInstrumentos::mdlEditarTecnica($tabla, $dataEditar);
    if (!$responseTenica) {
      return false;
    } else {
      $tabla = "instrumento";
      $listaInstrumentos = json_decode($dataTecnica["nuevaListaInstrumentos"], true);
      foreach ($listaInstrumentos as $instrumento) {
        //  Se verifica si el instrumento ya está creado o no; y se hace el create o el update
        if($instrumento["codInstrumento"] !=  null || $instrumento["codInstrumento"] != "") {
          $dataInstrumentoUpdate = array(
            "idInstrumento" => $instrumento["codInstrumento"],
            "descripcionInstrumento" => $instrumento["descripcion"],
            "codInstrumento" => $instrumento["codigo"],
            "fechaActualizacion" => date("Y-m-d H:i:s"),
            "usuarioActualizacion" => $_SESSION["idUsuario"]
          ); 
          $responseInstrumento = ModelTecnicaseInstrumentos::mdlEditarInstrumento($tabla, $dataInstrumentoUpdate);
        } else {
          $dataInstrumentoCreate = array(
            "idTecnicaEvaluacion" => $dataTecnica["idTecnica"],
            "descripcionInstrumento" => $instrumento["descripcion"],
            "codInstrumento" => $instrumento["codigo"],
            "fechaCreacion" => date("Y-m-d H:i:s"),
            "fechaActualizacion" => date("Y-m-d H:i:s"),
            "usuarioCreacion" => $_SESSION["idUsuario"],
            "usuarioActualizacion" => $_SESSION["idUsuario"]
          );
          $responseInstrumento = ModelTecnicaseInstrumentos::mdlCrearInstrumento($tabla, $dataInstrumentoCreate);
        }
      }
      if (!$responseInstrumento) {
        return false;
      } else {
        return true;
      }
    }
  }
}
