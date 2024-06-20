<?php
require_once "connection.php";

class ModelCompetencia
{

  /**
   * Obtener una competencia por su idCompetencia
   * 
   * @param string $tabla Nombre de la tabla
   * @param int $idCompetencia Id de la competencia
   * @return array $stmt->fetchAll() Datos de la competencia
   */

  public static function mdlObtenerCompetenciaPorId($tabla, $idCompetencia)
  {
    $stmt = Connection::conn()->prepare("SELECT * FROM $tabla WHERE idCompetencia = :idCompetencia");
    $stmt->bindParam(":idCompetencia", $idCompetencia, PDO::PARAM_INT);
    if ($stmt->execute()) {
      return $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
      return "error";
    }
  }

  // Obtener todas las competencias
  public static function mdlObtenerCompetencia($tabla, $idUnidad)
  {
    $stmt = Connection::conn()->prepare("SELECT
    competencias.idCompetencia, 
    competencias.descripcionCompetencia,
    competencias.capacidadesCompetencia,
    competencias.estandarCompetencia,
    MAX(nota_competencia.notaCompetencia) AS maxNotaCompetencia
FROM
    competencias
    INNER JOIN
    unidad
    ON 
      competencias.idUnidad = unidad.idUnidad
    LEFT JOIN
    nota_competencia
    ON 
      competencias.idCompetencia = nota_competencia.idCompetencia
WHERE
    competencias.idUnidad = :idUnidad
GROUP BY
    competencias.idCompetencia, 
    competencias.descripcionCompetencia");
    $stmt->bindParam(":idUnidad", $idUnidad, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Insertar Competencia
  public static function mdlCrearCompetencia($tabla, $arrayCompetencias)
  {
    $stmt = Connection::conn()->prepare("INSERT INTO $tabla(idUnidad, descripcionCompetencia, capacidadesCompetencia, estandarCompetencia, fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion) VALUES (:idUnidad, :descripcionCompetencia, :capacidadesCompetencia, :estandarCompetencia, :fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion)");
    $stmt->bindParam(":idUnidad", $arrayCompetencias["idUnidad"], PDO::PARAM_INT);
    $stmt->bindParam(":descripcionCompetencia", $arrayCompetencias["descripcionCompetencia"], PDO::PARAM_STR);
    $stmt->bindParam(":capacidadesCompetencia", $arrayCompetencias["capacidadesCompetencia"], PDO::PARAM_STR);
    $stmt->bindParam(":estandarCompetencia", $arrayCompetencias["estandarCompetencia"], PDO::PARAM_STR);
    $stmt->bindParam(":fechaCreacion", $arrayCompetencias["fechaCreacion"], PDO::PARAM_STR);
    $stmt->bindParam(":fechaActualizacion", $arrayCompetencias["fechaActualizacion"], PDO::PARAM_STR);
    $stmt->bindParam(":usuarioCreacion", $arrayCompetencias["usuarioCreacion"], PDO::PARAM_INT);
    $stmt->bindParam(":usuarioActualizacion", $arrayCompetencias["usuarioActualizacion"], PDO::PARAM_INT);
    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  // Modificar Competencia
  public static function mdlModificarCompetencia($tabla, $arrayCompetenciaMoficiada, $idCompetencia)
  {
    $stmt = Connection::conn()->prepare("UPDATE $tabla SET descripcionCompetencia = :descripcionCompetencia, capacidadesCompetencia = :capacidadesCompetencia, estandarCompetencia = :estandarCompetencia, fechaActualizacion = :fechaActualizacion, usuarioActualizacion = :usuarioActualizacion WHERE idCompetencia = :idCompetencia");
    $stmt->bindParam(":descripcionCompetencia", $arrayCompetenciaMoficiada["descripcionCompetencia"], PDO::PARAM_STR);
    $stmt->bindParam(":capacidadesCompetencia", $arrayCompetenciaMoficiada["capacidadesCompetencia"], PDO::PARAM_STR);
    $stmt->bindParam(":estandarCompetencia", $arrayCompetenciaMoficiada["estandarCompetencia"], PDO::PARAM_STR);
    $stmt->bindParam(":fechaActualizacion", $arrayCompetenciaMoficiada["fechaActualizacion"], PDO::PARAM_STR);
    $stmt->bindParam(":usuarioActualizacion", $arrayCompetenciaMoficiada["usuarioActualizacion"], PDO::PARAM_INT);
    $stmt->bindParam(":idCompetencia", $idCompetencia, PDO::PARAM_INT);
    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  // Obtener todas las competencias para duplicar
  public static function mdlDuplicarCompetencia($tabla, $idCursoDuplicar, $idGradoDuplicar, $idPersonalDuplicar)
  {
    $stmt = Connection::conn()->prepare("SELECT DISTINCT
    competencias.idCompetencia,
    competencias.descripcionCompetencia,      
    competencias.capacidadesCompetencia,
    competencias.estandarCompetencia,
    unidad.descripcionUnidad
    FROM
      $tabla
      INNER JOIN
      unidad
      ON 
        competencias.idUnidad = unidad.idUnidad
      INNER JOIN
      bimestre
      ON 
        unidad.idBimestre = bimestre.idBimestre
      INNER JOIN
      curso_grado
      ON 
        bimestre.idCursoGrado = curso_grado.idCursoGrado
      INNER JOIN
      cursogrado_personal
      ON 
        curso_grado.idCursoGrado = cursogrado_personal.idCursoGrado
    WHERE
      curso_grado.idCurso = :idCurso
     AND
      curso_grado.idGrado = :idGrado AND
      cursogrado_personal.idPersonal = :idPersonal");
    $stmt->bindParam(":idCurso", $idCursoDuplicar, PDO::PARAM_STR);
    $stmt->bindParam(":idGrado", $idGradoDuplicar, PDO::PARAM_STR);
    $stmt->bindParam(":idPersonal", $idPersonalDuplicar, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Verificar si ya existe la descripción de competencia
  public static function mdlVerificarCompetencia($tabla, $arrayCompetencias)
  {
    $stmtCheck = Connection::conn()->prepare("SELECT COUNT(*) as total FROM $tabla WHERE descripcionCompetencia = :descripcionCompetencia AND competencias.idUnidad = :idUnidad");
    $stmtCheck->bindParam(":descripcionCompetencia", $arrayCompetencias["descripcionCompetencia"], PDO::PARAM_STR);
    $stmtCheck->bindParam(":idUnidad", $arrayCompetencias["idUnidad"], PDO::PARAM_INT);
    $stmtCheck->execute();
    $resultado = $stmtCheck->fetch(PDO::FETCH_ASSOC);

    // Si la descripción ya existe, retornar un mensaje de error
    if ($resultado['total'] > 0) {
      return "error";
    }
    return "ok";
  }
  public static function mdlEliminarCompetencia($tabla, $idCompetenciaEliminar)
  {
    $stmt = Connection::conn()->prepare("DELETE competencias
    FROM competencias
    LEFT JOIN nota_competencia ON competencias.idCompetencia = nota_competencia.idCompetencia
    WHERE nota_competencia.idCompetencia IS NULL
    AND competencias.idCompetencia =  :idCompetencia");
    $stmt->bindParam(":idCompetencia", $idCompetenciaEliminar, PDO::PARAM_INT);
    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  public static function mdlValidarNotasCompetencias($tabla, $idUnidadValidacion, $idAlumnoAnioEscolar)
  {
    $stmt = Connection::conn()->prepare("SELECT
      nota_competencia.notaCompetencia, 
      competencias.idCompetencia
    FROM
      nota_competencia
      INNER JOIN
      competencias
      ON 
        nota_competencia.idCompetencia = competencias.idCompetencia
      INNER JOIN
      alumno_anio_escolar
      ON 
        alumno_anio_escolar.idAlumnoAnioEscolar = nota_competencia.idAlumnoAnioEscolar
    WHERE
      alumno_anio_escolar.idAlumnoAnioEscolar = :idAlumnoAnioEscolar AND
      competencias.idUnidad = :idUnidad");
    $stmt->bindParam(":idAlumnoAnioEscolar", $idAlumnoAnioEscolar, PDO::PARAM_INT);
    $stmt->bindParam(":idUnidad", $idUnidadValidacion, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Obtener ultima competencia creada
   * 
   * @param string $tabla Nombre de la tabla
   * @return array $stmt->fetch() Datos de la competencia
   */
  public static function mdlObtenerUltimaCompetencia($tabla)
  {
    $stmt = Connection::conn()->prepare("SELECT * FROM $tabla ORDER BY idCompetencia DESC LIMIT 1");
    if ($stmt->execute()) {
      return $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
      return "error";
    }
  }

  /**
   * Modelo para obtener todas las competencias con sus criterios asociados a dicha unidad
   * 
   * @param int $idUnidad id de la unidad
   * @return array todas las competencias asociados a la unidad con sus criterios
   */
  public static function mdlObtenerCompetenciaCriterios($idUnidad)
  {
    $stmt = Connection::conn()->prepare("SELECT
    competencias.idCompetencia,
    competencias.descripcionCompetencia,
    competencias.capacidadesCompetencia,
    competencias.estandarCompetencia,
    criterios_competencia.idCriterioCompetencia,
    criterios_competencia.descripcionCriterio
FROM
    competencias
    LEFT JOIN
    criterios_competencia
    ON 
      competencias.idCompetencia = criterios_competencia.idCompetencia
WHERE
    competencias.idUnidad = :idUnidad");
    $stmt->bindParam(":idUnidad", $idUnidad, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Modelo para obtener todas las competencias con sus criterios de una unidad y bimestre especifico
   * 
   * @param int $idUnidad id de la unidad
   * @param int $idBimestre id del bimestre
   * @return array todas las competencias asociados a la unidad con sus criterios
   */
  public static function mdlObtenerCompetenciaCriteriosPorIdUnidad($idUnidad, $idBimestre)
  {
    $stmt = Connection::conn()->prepare("SELECT
    competencias.idCompetencia,
    competencias.descripcionCompetencia,
    competencias.capacidadesCompetencia,
    competencias.estandarCompetencia,
    criterios_competencia.idCriterioCompetencia,
    criterios_competencia.descripcionCriterio
    FROM
    competencias
    LEFT JOIN
    criterios_competencia
    ON 
      competencias.idCompetencia = criterios_competencia.idCompetencia
    INNER JOIN
    unidad
    ON 
      competencias.idUnidad = unidad.idUnidad
    INNER JOIN
    bimestre
    ON 
      unidad.idBimestre = bimestre.idBimestre
    WHERE
    competencias.idUnidad = :idUnidad AND
    bimestre.idBimestre = :idBimestre");
    $stmt->bindParam(":idUnidad", $idUnidad, PDO::PARAM_INT);
    $stmt->bindParam(":idBimestre", $idBimestre, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
