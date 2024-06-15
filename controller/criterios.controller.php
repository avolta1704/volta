<?php
class ControllerCriterios
{
  /**
   * Obtiene todos los criterios de una competencia.
   * 
   * @param int $idCompetencia El ID de la competencia.
   * @return array Los criterios de la competencia.
   */
  public static function ctrGetAllCriterios($idCompetencia)
  {
    $tabla = "criterios_competencia";
    $respuesta = ModelCriterios::mdlGetAllCriterios($tabla, $idCompetencia);

    foreach ($respuesta as $key => $value) {
      $respuesta[$key]["acciones"] = FunctionsCriterios::botonesAcciones($value["idCriterioCompetencia"]);
    }
    return $respuesta;
  }

  /**
   * Obtiene todas las técnicas.
   * 
   * @return array Las técnicas.
   */
  public static function ctrGetAllTecnicas()
  {
    $tabla = "tecnica_evaluacion";
    $respuesta = ModelCriterios::mdlGetAllTecnicas($tabla);
    return $respuesta;
  }

  /**
   * Obtiene los instrumentos de una técnica.
   * 
   * @param int $idTecnica El ID de la técnica.
   * @return array Los instrumentos de la técnica.
   */
  public static function ctrGetInstrumentosByIdTecnica($idTecnica)
  {
    $tabla = "instrumento";
    $respuesta = ModelCriterios::mdlGetInstrumentosByIdTecnica($tabla, $idTecnica);
    return $respuesta;
  }

  /**
   * Crea un criterio.
   * 
   * @param int $idCompetencia El ID de la competencia.
   * @param array $nuevoCriterio El criterio a crear.
   * @return string $respuesta La respuesta de la creación del criterio ok si se creo y error si hubo un error.
   */
  public static function ctrCrearCriterio($idCompetencia, $nuevoCriterio)
  {
    $tabla = "criterios_competencia";

    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }

    $nuevoCriterio["usuarioCreacion"] = $_SESSION["idUsuario"];
    $nuevoCriterio["usuarioActualizacion"] = $_SESSION["idUsuario"];
    $nuevoCriterio["fechaCreacion"] = date("Y-m-d H:i:s");
    $nuevoCriterio["fechaActualizacion"] = date("Y-m-d H:i:s");

    $respuesta = ModelCriterios::mdlCrearCriterio($tabla, $idCompetencia, $nuevoCriterio);
    return $respuesta;
  }
}
