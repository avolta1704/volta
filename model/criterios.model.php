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
    $tablaTecnicas = "tecnica_evaluacion";
    $tablaInstrumentos = "instrumento";
    $stmt = Connection::conn()->prepare("SELECT c.idCriterioCompetencia, c.descripcionCriterio, t.idTecnicaEvaluacion, t.codTecnica, i.idInstrumento, i.codInstrumento FROM $tabla as c INNER JOIN $tablaTecnicas as t ON c.idTecnicaEvaluacion = t.idTecnicaEvaluacion INNER JOIN $tablaInstrumentos as i ON c.idInstrumento = i.idInstrumento WHERE idCompetencia = :idCompetencia");
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

  /**
   * Crea un criterio.
   * 
   * @param string $tabla La tabla de la base de datos.
   * @param int $idCompetencia El ID de la competencia.
   * @param array $nuevoCriterio El criterio a crear.
   * @return string $respuesta La respuesta de la creación del criterio ok si se creo y error si hubo un error.
   */
  public static function mdlCrearCriterio($tabla, $idCompetencia, $nuevoCriterio)
  {
    $stmt = Connection::conn()->prepare("INSERT INTO $tabla (idCompetencia, descripcionCriterio, idTecnicaEvaluacion, idInstrumento, fechaCreacion, usuarioCreacion, usuarioActualizacion, fechaActualizacion) VALUES (:idCompetencia, :descripcionCriterio, :idTecnicaEvaluacion, :idInstrumento, :fechaCreacion, :usuarioCreacion, :usuarioActualizacion, :fechaActualizacion)");
    $stmt->bindParam(":idCompetencia", $idCompetencia, PDO::PARAM_INT);
    $stmt->bindParam(":descripcionCriterio", $nuevoCriterio["descripcionCriterio"], PDO::PARAM_STR);
    $stmt->bindParam(":idTecnicaEvaluacion", $nuevoCriterio["idTecnicaEvaluacion"], PDO::PARAM_INT);
    $stmt->bindParam(":idInstrumento", $nuevoCriterio["idInstrumento"], PDO::PARAM_INT);
    $stmt->bindParam(":usuarioCreacion", $nuevoCriterio["usuarioCreacion"], PDO::PARAM_INT);
    $stmt->bindParam(":usuarioActualizacion", $nuevoCriterio["usuarioActualizacion"], PDO::PARAM_INT);
    $stmt->bindParam(":fechaCreacion", $nuevoCriterio["fechaCreacion"], PDO::PARAM_STR);
    $stmt->bindParam(":fechaActualizacion", $nuevoCriterio["fechaActualizacion"], PDO::PARAM_STR);
    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  /**
   * Elimina un criterio.
   * 
   * @param string $tabla La tabla de la base de datos.
   * @param int $idCriterioCompetencia El ID del criterio.
   * @return string $respuesta La respuesta de la eliminación del criterio ok si se elimino y error si hubo un error.
   */
  public static function mdlEliminarCriterio($tabla, $idCriterioCompetencia)
  {
    $stmt = Connection::conn()->prepare("DELETE FROM $tabla WHERE idCriterioCompetencia = :idCriterioCompetencia");
    $stmt->bindParam(":idCriterioCompetencia", $idCriterioCompetencia, PDO::PARAM_INT);
    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  /**
   * Obtiene las notas criterio de un criterio por su idCriterio.
   * 
   * @param string $tabla La tabla de la base de datos.
   * @param int $idCriterioCompetencia El ID del criterio.
   * @return array Las notas criterio del criterio.
   */
  public static function mdlGetNotaCriterioByIdCriterio($tabla, $idCriterioCompetencia)
  {
    $stmt = Connection::conn()->prepare("SELECT * FROM $tabla WHERE idCriterioCompetencia = :idCriterioCompetencia");
    $stmt->bindParam(":idCriterioCompetencia", $idCriterioCompetencia, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  /**
   * Editar un criterio.
   * 
   * @param string $tabla La tabla de la base de datos.
   * @param int $idCriterioCompetencia El ID del criterio.
   * @param array $criterio El criterio a editar.
   * @return string $respuesta La respuesta de la edición del criterio ok si se edito y error si hubo un error.
   */
  public static function mdlEditarCriterio($tabla, $idCriterioCompetencia, $criterio)
  {
    $stmt = Connection::conn()->prepare("UPDATE $tabla SET descripcionCriterio = :descripcionCriterio, idTecnicaEvaluacion = :idTecnicaEvaluacion, idInstrumento = :idInstrumento, usuarioActualizacion = :usuarioActualizacion, fechaActualizacion = :fechaActualizacion WHERE idCriterioCompetencia = :idCriterioCompetencia");
    $stmt->bindParam(":descripcionCriterio", $criterio["descripcionCriterio"], PDO::PARAM_STR);
    $stmt->bindParam(":idTecnicaEvaluacion", $criterio["idTecnicaEvaluacion"], PDO::PARAM_INT);
    $stmt->bindParam(":idInstrumento", $criterio["idInstrumento"], PDO::PARAM_INT);
    $stmt->bindParam(":usuarioActualizacion", $criterio["usuarioActualizacion"], PDO::PARAM_INT);
    $stmt->bindParam(":fechaActualizacion", $criterio["fechaActualizacion"], PDO::PARAM_STR);
    $stmt->bindParam(":idCriterioCompetencia", $idCriterioCompetencia, PDO::PARAM_INT);
    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
}
