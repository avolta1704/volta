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
}
