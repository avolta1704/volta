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

  public static function mdlObtenerTodoslosDatosparaAsignarNota($tabla, $idUnidadCerrar, $idAlumnoAnioEscolar)
  {
    $stmt = Connection::conn()->prepare("SELECT
      nota_competencia.idNotaCompetencia, 
      nota_competencia.notaCompetencia, 
      nota_unidad.notaUnidad, 
      competencias.idUnidad, 
      competencias.descripcionCompetencia, 
      nota_unidad.idNotaUnidad, 
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
      nota_unidad
      ON 
        nota_competencia.idNotaUnidad = nota_unidad.idNotaUnidad AND
        unidad.idUnidad = nota_unidad.idUnidad
      INNER JOIN
      alumno_anio_escolar
      ON 
        nota_unidad.idAlumnoAnioEscolar = alumno_anio_escolar.idAlumnoAnioEscolar
    WHERE
      nota_unidad.idUnidad = :idUnidadCerrar AND
      alumno_anio_escolar.idAlumnoAnioEscolar = :idAlumnoAnioEscolar");
    $stmt->bindParam(":idUnidadCerrar", $idUnidadCerrar, PDO::PARAM_INT);
    $stmt->bindParam(":idAlumnoAnioEscolar",$idAlumnoAnioEscolar, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  public static function mdlInsertarNotaUnidad($tabla, $idNotaUnidad, $notaUnidad, $idAlumnoAnioEscolar)
  {
    $stmt = Connection::conn()->prepare("UPDATE $tabla SET notaUnidad = :notaUnidad WHERE idNotaUnidad = :idNotaUnidad AND idAlumnoAnioEscolar = :idAlumnoAnioEscolar");
    $stmt->bindParam(":notaUnidad", $notaUnidad, PDO::PARAM_STR);
    $stmt->bindParam(":idNotaUnidad", $idNotaUnidad, PDO::PARAM_INT);
    $stmt->bindParam(":idAlumnoAnioEscolar", $idAlumnoAnioEscolar, PDO::PARAM_INT);
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


}
