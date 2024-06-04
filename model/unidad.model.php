<?php
require_once "connection.php";

class ModelUnidad
{

  public static function mdlInsertarUnidad($dataUnidad)
  {
    $stmt = Connection::conn()->prepare("INSERT INTO unidad (idBimestre, descripcionUnidad, estadoUnidad, fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion) VALUES (:idBimestre, :descripcionUnidad, :estadoUnidad, :fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion)");

    $stmt->bindParam(":idBimestre", $dataUnidad["idBimestre"], PDO::PARAM_INT);
    $stmt->bindParam(":descripcionUnidad", $dataUnidad["descripcionUnidad"], PDO::PARAM_STR);
    $stmt->bindParam(":estadoUnidad", $dataUnidad["estadoUnidad"], PDO::PARAM_INT);
    $stmt->bindParam(":fechaCreacion", $dataUnidad["fechaCreacion"], PDO::PARAM_STR);
    $stmt->bindParam(":fechaActualizacion", $dataUnidad["fechaActualizacion"], PDO::PARAM_STR);
    $stmt->bindParam(":usuarioCreacion", $dataUnidad["usuarioCreacion"], PDO::PARAM_INT);
    $stmt->bindParam(":usuarioActualizacion", $dataUnidad["usuarioActualizacion"], PDO::PARAM_INT);

    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  // Obtener todas las unidades
  public static function mdlObtenerTodasLasUnidades($tabla, $idBimestre)
  {
    $stmt = Connection::conn()->prepare("SELECT
    descripcionUnidad, 
    unidad.idUnidad,
    unidad.estadoUnidad
  FROM
    $tabla
    INNER JOIN
    bimestre
    ON 
      unidad.idBimestre = bimestre.idBimestre
  WHERE
    bimestre.idBimestre = :idBimestre;");
    $stmt->bindParam(":idBimestre", $idBimestre, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Obtener todas las competencias
  public static function mdlObtenerCompetencia($tabla, $idUnidad)
  {
    $stmt = Connection::conn()->prepare("SELECT
      competencias.idCompetencia, 
      competencias.descripcionCompetencia
    FROM
      $tabla
      INNER JOIN
      unidad
      ON 
        competencias.idUnidad = unidad.idUnidad
    WHERE
      competencias.idUnidad = :idUnidad");
    $stmt->bindParam(":idUnidad", $idUnidad, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Insertar Competencia
  public static function mdlCrearCompetencia($tabla, $arrayCompetencias)
  {
    $stmt = Connection::conn()->prepare("INSERT INTO $tabla(idUnidad, descripcionCompetencia, fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion) VALUES (:idUnidad, :descripcionCompetencia, :fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion)");
    $stmt->bindParam(":idUnidad", $arrayCompetencias["idUnidad"], PDO::PARAM_INT);
    $stmt->bindParam(":descripcionCompetencia", $arrayCompetencias["descripcionCompetencia"], PDO::PARAM_STR);
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
    $stmt = Connection::conn()->prepare("UPDATE $tabla SET descripcionCompetencia = :descripcionCompetencia, fechaActualizacion = :fechaActualizacion, usuarioActualizacion = :usuarioActualizacion WHERE idCompetencia = :idCompetencia");
    $stmt->bindParam(":descripcionCompetencia", $arrayCompetenciaMoficiada["descripcionCompetencia"], PDO::PARAM_STR);
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
      competencias.descripcionCompetencia
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

  // Insertar Competencia dUPLICADA
  public static function mdlInsertarDuplicadosCompetencia($tabla, $arrayCompetencias)
  {
    // Verificar si ya existe la descripción de competencia
    $stmtCheck = Connection::conn()->prepare("SELECT COUNT(*) as total FROM $tabla WHERE descripcionCompetencia = :descripcionCompetencia AND
    competencias.idUnidad = :idUnidad");
    $stmtCheck->bindParam(":descripcionCompetencia", $arrayCompetencias["descripcionCompetencia"], PDO::PARAM_STR);
    $stmtCheck->bindParam(":idUnidad", $arrayCompetencias["idUnidad"], PDO::PARAM_INT);
    $stmtCheck->execute();
    $resultado = $stmtCheck->fetch(PDO::FETCH_ASSOC);

    // Si la descripción ya existe, retornar un mensaje de error
    if ($resultado['total'] > 0) {
      return "existe";
    }

    // Insertar la competencia si no existe
    $stmt = Connection::conn()->prepare("INSERT INTO $tabla(idUnidad, descripcionCompetencia, fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion) VALUES (:idUnidad, :descripcionCompetencia, :fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion)");
    $stmt->bindParam(":idUnidad", $arrayCompetencias["idUnidad"], PDO::PARAM_INT);
    $stmt->bindParam(":descripcionCompetencia", $arrayCompetencias["descripcionCompetencia"], PDO::PARAM_STR);
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

}
