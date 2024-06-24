<?php
date_default_timezone_set('America/Lima');
class ControllerAnioPostulacion
{
  //  Crear anio_postulacion
  public static function ctrCrearAnioPostulacion($idPostulante, $anioEscolar)
  {
    $table = "anio_postulante";
    $dataCreate = array(
      "idPostulante" => $idPostulante,
      "idAnioEscolar" => $anioEscolar,
      "fechaCreacion" => date("Y-m-d H:i:s"),
      "fechaActualizacion" => date("Y-m-d H:i:s"),
      "usuarioCreacion" => $_SESSION["idUsuario"],
      "usuarioActualizacion" => $_SESSION["idUsuario"]
    );
    $response = ModelAnioPostulante::mdlCrearAnioPostulante($table, $dataCreate);
    return $response;
  }

  /**
   * Editar año de postulación
   * 
   * @param int $anioEscolar
   * @param int $idAnioPostulacion
   * @return string
   */
  public static function ctrEditarAnioPostulacion($anioEscolar, $idAnioPostulacion) {
    $tabla = "anio_postulante";
    $dataUpdate = array(
      "idAnioEscolar" => $anioEscolar,
      "idAnioPostulante" => $idAnioPostulacion,
      "fechaActualizacion" => date("Y-m-d H:i:s"),
      "usuarioActualizacion" => $_SESSION["idUsuario"]
    );
    $response = ModelAnioPostulante::mdlEditarAnioPostulante($tabla, $dataUpdate);
    return $response;
  }
}
