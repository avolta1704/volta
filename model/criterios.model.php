<?php
require_once "connection.php";
class ModelCriterios
{

  /**
   * Obtiene todos los criterios de una competencia.
   * 
   * @param string $tabla La tabla de la base de datos.
   * @param int $idCompetencia El ID de la competencia.
   * @return array Los criterios de la competencia.
   */
  public static function mdlGetAllCriterios($tabla, $idCompetencia)
  {
    $stmt = Connection::conn()->prepare("SELECT * FROM $tabla WHERE idCompetencia = :idCompetencia");
    $stmt->bindParam(":idCompetencia", $idCompetencia, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  /**
   * Obtiene todas las técnicas.
   * 
   * @param string $tabla La tabla de la base de datos.
   * @return array Las técnicas.
   */
  public static function mdlGetAllTecnicas($tabla)
  {
    $stmt = Connection::conn()->prepare("SELECT * FROM $tabla");
    $stmt->execute();
    return $stmt->fetchAll();
  }

  /**
   * Obtiene los instrumentos de una técnica.
   * 
   * @param string $tabla La tabla de la base de datos.
   * @param int $idTecnicaEvaluacion El ID de la técnica.
   * @return array Los instrumentos de la técnica.
   */
  public static function mdlGetInstrumentosByIdTecnica($tabla, $idTecnicaEvaluacion)
  {
    $stmt = Connection::conn()->prepare("SELECT * FROM $tabla WHERE idTecnicaEvaluacion = :idTecnicaEvaluacion");
    $stmt->bindParam(":idTecnicaEvaluacion", $idTecnicaEvaluacion, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
  }
}
