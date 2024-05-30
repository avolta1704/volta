<?php
date_default_timezone_set('America/Lima');
class ControllerAnioCursoGrado
{
  //  Crear anio_postulacion
  public static function ctrCrearAnioCursoGrado($idCursoGradoPersonal,$anioEscolarActiva)
  {
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    $table = "anio_cursogrado";
    $dataaniocursoGrado = array(
      "idCursoGradoPersonal" => $idCursoGradoPersonal,
      "idAnioEscolar" => $anioEscolarActiva,
      "fechaCreacion" => date("Y-m-d H:i:s"),
      "fechaActualizacion" => date("Y-m-d H:i:s"),
      "usuarioCreacion" => $_SESSION["idUsuario"],
      "usuarioActualizacion" => $_SESSION["idUsuario"]
    );
    $response = ModelAnioCursoGrado::mdlCrearAnioCursoGrado($table, $dataaniocursoGrado);
    return $response;
  }
}
