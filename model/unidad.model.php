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

  public static function mdlCerrarUnidad($tabla, $idUnidadCerrar)
  {
    $stmt = Connection::conn()->prepare("UPDATE $tabla SET estadoUnidad = 0 WHERE idUnidad = :idUnidad");
    $stmt->bindParam(":idUnidad", $idUnidadCerrar, PDO::PARAM_INT);
    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  public static function mdlObtenerTodoslosDatosparaAsignarNota($idUnidadCerrar, $idAlumnoAnioEscolar)
  {
    $stmt = Connection::conn()->prepare("SELECT
      nota_competencia.idNotaCompetencia, 
      nota_competencia.notaCompetencia, 
      competencias.idUnidad, 
      competencias.descripcionCompetencia, 
      alumno_anio_escolar.idAlumnoAnioEscolar
    FROM
      unidad
      INNER JOIN
      competencias
      ON 
        unidad.idUnidad = competencias.idUnidad
      INNER JOIN
      nota_competencia
      ON 
        competencias.idCompetencia = nota_competencia.idCompetencia
      INNER JOIN
      alumno_anio_escolar
      ON 
        nota_unidad.idAlumnoAnioEscolar = alumno_anio_escolar.idAlumnoAnioEscolar
    WHERE
      nota_unidad.idUnidad = :idUnidadCerrar AND
      alumno_anio_escolar.idAlumnoAnioEscolar = :idAlumnoAnioEscolar");
    $stmt->bindParam(":idUnidadCerrar", $idUnidadCerrar, PDO::PARAM_INT);
    $stmt->bindParam(":idAlumnoAnioEscolar", $idAlumnoAnioEscolar, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Insertar la nota de la unidad
   * 
   * @param string $tabla tabla de la base de datos
   * @param int $idUnidad id de la unidad
   * @param int $idAlumnoAnioEscolar id del alumno
   * @param int $notaUnidad nota de la unidad
   * @return string "ok" si la inserción fue exitosa, "error" si no 
   */

  public static function mdlInsertarNotaUnidad($tabla, $idUnidad, $idAlumnoAnioEscolar, $notaUnidad)
  {
    $stmt = Connection::conn()->prepare("INSERT INTO $tabla (notaUnidad, idAlumnoAnioEscolar, idUnidad, idCursoGradoPersonal, fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion) VALUES (:notaUnidad, :idAlumnoAnioEscolar, :idUnidad, :idCursoGradoPersonal, :fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion)");
    $stmt->bindParam(":notaUnidad", $notaUnidad["notaUnidad"], PDO::PARAM_STR);
    $stmt->bindParam(":idAlumnoAnioEscolar", $idAlumnoAnioEscolar, PDO::PARAM_INT);
    $stmt->bindParam(":idUnidad", $idUnidad, PDO::PARAM_INT);
    $stmt->bindParam(":idCursoGradoPersonal", $notaUnidad["idCursoGradoPersonal"], PDO::PARAM_INT);
    $stmt->bindParam(":fechaCreacion", $notaUnidad["fechaCreacion"], PDO::PARAM_STR);
    $stmt->bindParam(":fechaActualizacion", $notaUnidad["fechaActualizacion"], PDO::PARAM_STR);
    $stmt->bindParam(":usuarioCreacion", $notaUnidad["usuarioCreacion"], PDO::PARAM_INT);
    $stmt->bindParam(":usuarioActualizacion", $notaUnidad["usuarioActualizacion"], PDO::PARAM_INT);
    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  public static function mdlActivarUnidad($idUnidadActivar, $estadoUnidadNuevo)
  {
    $stmt = Connection::conn()->prepare("UPDATE unidad
      SET estadoUnidad = :estadoUnidad
      WHERE idUnidad = :idUnidad");
    $stmt->bindParam(":idUnidad", $idUnidadActivar, PDO::PARAM_INT);
    $stmt->bindParam(":estadoUnidad", $estadoUnidadNuevo, PDO::PARAM_INT);
    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  /**
   * Obtener una unidad por su id
   * 
   * @param int $idUnidad id de la unidad
   * @return array $dataUnidad datos de la unidad 
   */
  public static function mdlObtenerUnidadById($tabla, $idUnidad)
  {
    $stmt = Connection::conn()->prepare("SELECT * FROM $tabla WHERE idUnidad = :idUnidad");
    $stmt->bindParam(":idUnidad", $idUnidad, PDO::PARAM_INT);
    if ($stmt->execute()) {
      return $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
      return "error";
    }
  }

  /**
   * Obtener las competencias de una unidad
   * 
   * @param int $idUnidad id de la unidad
   * @return array $dataCompetencias datos de las competencias
   */
  public static function mdlObtenerCompetenciasUnidad($idUnidad)
  {
    $stmt = Connection::conn()->prepare("SELECT * FROM competencias WHERE idUnidad = :idUnidad");
    $stmt->bindParam(":idUnidad", $idUnidad, PDO::PARAM_INT);
    if ($stmt->execute()) {
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
      return "error";
    }
  }

  /**
   * Obtener todas la nota de un competencia de un alumno
   * 
   * @param string $tabla tabla de la base de datos
   * @param int $idAlumnoAnioEscolar id del alumno
   * @param int $idCompetencia id de la competencia
   * @return array $notaCompetencia datos de la nota de la competencia o "error" si hubo un error
   */
  public static function mdlObtenerNotaCompetencia($tabla, $idAlumnoAnioEscolar, $idCompetencia)
  {
    $stmt = Connection::conn()->prepare("SELECT idNotaCompetencia, notaCompetencia FROM $tabla WHERE idAlumnoAnioEscolar = :idAlumnoAnioEscolar AND idCompetencia = :idCompetencia");
    $stmt->bindParam(":idAlumnoAnioEscolar", $idAlumnoAnioEscolar, PDO::PARAM_INT);
    $stmt->bindParam(":idCompetencia", $idCompetencia, PDO::PARAM_INT);
    if ($stmt->execute()) {
      return $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
      return "error";
    }
  }

  /**
   * Obtener las notas de la unidad de un alumno
   * 
   * @param string $tabla tabla de la base de datos
   * @param int $idUnidad id de la unidad
   * @param int $idAlumnoAnioEscolar id del alumno
   * @param int $idCursoGradoPersonal id del curso, grado y personal
   * @return array $notasUnidad datos de las notas de la unidad
   */
  public static function mdlObtenerNotaUnidad($tabla, $idUnidad, $idAlumnoAnioEscolar, $idCursoGradoPersonal)
  {
    $stmt = Connection::conn()->prepare("SELECT idNotaUnidad, notaUnidad FROM $tabla WHERE idUnidad = :idUnidad AND idAlumnoAnioEscolar = :idAlumnoAnioEscolar AND idCursoGradoPersonal = :idCursoGradoPersonal");
    $stmt->bindParam(":idUnidad", $idUnidad, PDO::PARAM_INT);
    $stmt->bindParam(":idAlumnoAnioEscolar", $idAlumnoAnioEscolar, PDO::PARAM_INT);
    $stmt->bindParam(":idCursoGradoPersonal", $idCursoGradoPersonal, PDO::PARAM_INT);
    if ($stmt->execute()) {
      return $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
      return "error";
    }
  }
}
