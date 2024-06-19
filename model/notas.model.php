<?php

require_once "connection.php";

class ModelNotas
{
  /**
   * Modelo para obtener la nota de un alumno en un criterio
   * 
   * @param int $idAlumnoAnioEscolar id del alumno anio escolar
   * @param int $idCriterio id del criterio
   * @param int $idCompetencia id de la competencia
   * @param int $idUnidad id de la unidad
   * @param int $idBimestre id del bimestre
   * @return array con la nota del alumno en un criterio
   */
  public static function mdlObtenerNotaAlumnoCriterio($idAlumnoAnioEscolar, $idCriterio, $idCompetencia, $idUnidad, $idBimestre)
  {

    $tablaNotaCriterios = "nota_criterio";
    $tablaCriterios = "criterios_competencia";
    $tablaCompetencia = "competencias";
    $tablaUnidad = "unidad";
    $tablaBimestre = "bimestre";
    $tablaAlumnoAnioEscolar = "alumno_anio_escolar";

    $stmt = Connection::conn()->prepare("SELECT
      nota_c.idNotaCriterio,
      nota_c.notaCriterio
    FROM
      $tablaNotaCriterios as nota_c
    INNER JOIN
      $tablaCriterios as cr
    ON
      nota_c.idCriterioCompetencia = cr.idCriterioCompetencia
    INNER JOIN
      $tablaCompetencia as co
    ON
      cr.idCompetencia = co.idCompetencia
    INNER JOIN
      $tablaUnidad as un
    ON
      co.idUnidad = un.idUnidad
    INNER JOIN
      $tablaBimestre as b
    ON
      un.idBimestre = b.idBimestre
    INNER JOIN
      $tablaAlumnoAnioEscolar as aae
    ON
      nota_c.idAlumnoAnioEscolar = aae.idAlumnoAnioEscolar
    WHERE
      nota_c.idAlumnoAnioEscolar = :idAlumnoAnioEscolar AND
      cr.idCriterioCompetencia = :idCriterio AND
      b.idBimestre = :idBimestre AND
      un.idUnidad = :idUnidad AND
      co.idCompetencia = :idCompetencia");
    $stmt->bindParam(":idAlumnoAnioEscolar", $idAlumnoAnioEscolar, PDO::PARAM_INT);
    $stmt->bindParam(":idCriterio", $idCriterio, PDO::PARAM_INT);
    $stmt->bindParam(":idBimestre", $idBimestre, PDO::PARAM_INT);
    $stmt->bindParam(":idUnidad", $idUnidad, PDO::PARAM_INT);
    $stmt->bindParam(":idCompetencia", $idCompetencia, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Modelo para obtener una nota de un alumno en un criterio
   * 
   * @param int $idNotaCriterio id de la nota criterio
   * @return array con la nota del alumno en un criterio
   */
  public static function mdlObtenerNotaAlumnoCriterioPorId($idNotaCriterio)
  {
    $tablaNotaCriterios = "nota_criterio";
    $stmt = Connection::conn()->prepare("SELECT
      notaCriterio
    FROM
      $tablaNotaCriterios
    WHERE
      idNotaCriterio = :idNotaCriterio");
    $stmt->bindParam(":idNotaCriterio", $idNotaCriterio, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Modelo para actualizar una nota
   * 
   * @param int $idNotaCriterio id de la nota criterio
   * @param string $nota nota del criterio
   * @return string con el resultado de la consulta
   */
  public static function mdlActualizarNota($idNotaCriterio, $nota)
  {
    $tablaNotaCriterios = "nota_criterio";
    $stmt = Connection::conn()->prepare("UPDATE
      $tablaNotaCriterios
    SET
      notaCriterio = :nota
    WHERE
      idNotaCriterio = :idNotaCriterio");
    $stmt->bindParam(":nota", $nota, PDO::PARAM_STR);
    $stmt->bindParam(":idNotaCriterio", $idNotaCriterio, PDO::PARAM_INT);
    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  /**
   * Modelo para crear una nota
   * 
   * @param int $idAlumnoAnioEscolar id del alumno año escolar
   * @param int $idCriterioCompetencia id del criterio de competencia
   * @param string $nota nota del criterio
   */
  public static function mdlCrearNota($idAlumnoAnioEscolar, $idCriterioCompetencia, $nota)
  {
    $tablaNotaCriterios = "nota_criterio";
    $stmt = Connection::conn()->prepare("INSERT INTO
      $tablaNotaCriterios
    (idAlumnoAnioEscolar, idCriterioCompetencia, notaCriterio)
    VALUES
      (:idAlumnoAnioEscolar, :idCriterioCompetencia, :nota)");
    $stmt->bindParam(":idAlumnoAnioEscolar", $idAlumnoAnioEscolar, PDO::PARAM_INT);
    $stmt->bindParam(":idCriterioCompetencia", $idCriterioCompetencia, PDO::PARAM_INT);
    $stmt->bindParam(":nota", $nota, PDO::PARAM_STR);
    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  /**
   * Modelo para eliminar una nota
   * 
   * @param int $idNotaCriterio id de la nota criterio
   * @return string con el resultado de la consulta
   */
  public static function mdlEliminarNota($idNotaCriterio)
  {
    $tablaNotaCriterios = "nota_criterio";
    $stmt = Connection::conn()->prepare("DELETE FROM
      $tablaNotaCriterios
    WHERE
      idNotaCriterio = :idNotaCriterio");
    $stmt->bindParam(":idNotaCriterio", $idNotaCriterio, PDO::PARAM_INT);
    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
}
