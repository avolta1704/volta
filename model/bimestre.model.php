<?php
require_once "connection.php";

class ModelBimestre
{

  public static function mdlInsertarBimestre($dataBimestre)
  {
    $stmt = Connection::conn()->prepare("INSERT INTO bimestre (idCursoGrado, descripcionBimestre, estadoBimestre, fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion) VALUES (:idCursoGrado, :descripcionBimestre, :estadoBimestre, :fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion)");

    $stmt->bindParam(":idCursoGrado", $dataBimestre["idCursoGrado"], PDO::PARAM_INT);
    $stmt->bindParam(":descripcionBimestre", $dataBimestre["descripcionBimestre"], PDO::PARAM_STR);
    $stmt->bindParam(":estadoBimestre", $dataBimestre["estadoBimestre"], PDO::PARAM_INT);
    $stmt->bindParam(":fechaCreacion", $dataBimestre["fechaCreacion"], PDO::PARAM_STR);
    $stmt->bindParam(":fechaActualizacion", $dataBimestre["fechaActualizacion"], PDO::PARAM_STR);
    $stmt->bindParam(":usuarioCreacion", $dataBimestre["usuarioCreacion"], PDO::PARAM_INT);
    $stmt->bindParam(":usuarioActualizacion", $dataBimestre["usuarioActualizacion"], PDO::PARAM_INT);

    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  public static function mdlObtenerUltimoIdCreado($idCursoGrado)
  {
    $stmt = Connection::conn()->prepare("SELECT idBimestre FROM bimestre where idCursoGrado = :idCursoGrado");
    $stmt->bindParam(":idCursoGrado", $idCursoGrado, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  // Obtener todos los bimestres
  public static function mdlObtenerTodosLosBimestres($tabla, $idCurso, $idGrado)
  {
    $stmt = Connection::conn()->prepare("SELECT
    bimestre.idBimestre, 
    bimestre.descripcionBimestre,
    bimestre.estadoBimestre
  FROM
    $tabla
    INNER JOIN
    curso_grado
    ON 
      bimestre.idCursoGrado = curso_grado.idCursoGrado
  WHERE
    curso_grado.idCurso = :idCurso AND
    curso_grado.idGrado = :idGrado");
    $stmt->bindParam(":idCurso", $idCurso, PDO::PARAM_INT);
    $stmt->bindParam(":idGrado", $idGrado, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  //Obtener el idCursoGrado
  public static function mdlObtenerCursoGradoBimestre($idBimestre)
  {
    $stmt = Connection::conn()->prepare("SELECT
    bimestre.idCursoGrado
  FROM
    bimestre
  WHERE
    bimestre.idBimestre =:idBimestre");
    $stmt->bindParam(":idBimestre", $idBimestre, PDO::PARAM_INT);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    return $resultado['idCursoGrado']; // Retorna específicamente el idCursoGrado
  }

  //Obtener todos los bimestres y estados de los bimestres con sus unidades
  public static function mdlObtenerTodosLosBimestresyUnidadesEstados($idCursoGrado)
  {
    $stmt = Connection::conn()->prepare("SELECT
      bimestre.idBimestre, 
      bimestre.estadoBimestre, 
      unidad.idUnidad, 
      unidad.estadoUnidad
      FROM
        bimestre
        INNER JOIN
        unidad
        ON 
          bimestre.idBimestre = unidad.idBimestre
      WHERE
        bimestre.idCursoGrado =:idCursoGrado");
    $stmt->bindParam(":idCursoGrado", $idCursoGrado, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  public static function mdlActualizarEstadoBimestreCerrarUnidad($idBimestre, $estadoBimestrenuevo)
  {
    $stmt = Connection::conn()->prepare("UPDATE bimestre
      SET estadoBimestre = :estadoBimestre
      WHERE idBimestre = :idBimestre");
    $stmt->bindParam(":idBimestre", $idBimestre, PDO::PARAM_INT);
    $stmt->bindParam(":estadoBimestre", $estadoBimestrenuevo, PDO::PARAM_INT);
    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  public static function mdlObtenerTodaslasNotasdeUnidad($idBimestre, $idAlumnoAnioEscolar)
  {
    $stmt = Connection::conn()->prepare("SELECT
      unidad.idUnidad, 
      nota_unidad.notaUnidad, 
      nota_bimestre.notaBimestre
    FROM
      nota_unidad
      INNER JOIN
      unidad
      ON 
        nota_unidad.idUnidad = unidad.idUnidad
      INNER JOIN
      bimestre
      ON 
        unidad.idBimestre = bimestre.idBimestre
      LEFT JOIN
      nota_bimestre
      ON 
        bimestre.idBimestre = nota_bimestre.idBimestre
      INNER JOIN
      alumno_anio_escolar
      ON 
        nota_bimestre.idAlumnoAnioEscolar = alumno_anio_escolar.idAlumnoAnioEscolar AND
        nota_unidad.idAlumnoAnioEscolar = alumno_anio_escolar.idAlumnoAnioEscolar
    WHERE
      bimestre.idBimestre = :idBimestre AND
      alumno_anio_escolar.idAlumnoAnioEscolar = :idAlumnoAnioEscolar");
    $stmt->bindParam(":idBimestre", $idBimestre, PDO::PARAM_INT);
    $stmt->bindParam(":idAlumnoAnioEscolar", $idAlumnoAnioEscolar, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public static function mdlSubirNotaPromedioBimestreUnidad($idBimestre,$promedioNotas, $idAlumnoAnioEscolar){
    $stmt = Connection::conn()->prepare("UPDATE nota_bimestre
      SET notaBimestre = :notaBimestre
      WHERE idBimestre = :idBimestre
      AND idAlumnoAnioEscolar = :idAlumnoAnioEscolar");
    $stmt->bindParam(":idBimestre", $idBimestre, PDO::PARAM_INT);
    $stmt->bindParam(":notaBimestre", $promedioNotas, PDO::PARAM_STR);
    $stmt->bindParam(":idAlumnoAnioEscolar", $idAlumnoAnioEscolar, PDO::PARAM_INT);
    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

}
