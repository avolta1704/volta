<?php

require_once "connection.php";
class ModelAlumnoAnioEscolar
{
  //  Crear anio_admision
  static public function mdlCrearAlumnoAnioEscolar($tabla, $arrayAnio)
  {
    $stmt = Connection::conn()->prepare("INSERT INTO $tabla (idAnioEscolar, idAlumno, idGrado, fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion) VALUES (:idAnioEscolar, :idAlumno, :idGrado, :fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion)");
    $stmt->bindParam(":idAnioEscolar", $arrayAnio["idAnioEscolar"], PDO::PARAM_INT);
    $stmt->bindParam(":idAlumno", $arrayAnio["idAlumno"], PDO::PARAM_INT);
    $stmt->bindParam(":idGrado", $arrayAnio["idGrado"], PDO::PARAM_INT);
    $stmt->bindParam(":fechaCreacion", $arrayAnio["fechaCreacion"], PDO::PARAM_STR);
    $stmt->bindParam(":fechaActualizacion", $arrayAnio["fechaActualizacion"], PDO::PARAM_STR);
    $stmt->bindParam(":usuarioCreacion", $arrayAnio["usuarioCreacion"], PDO::PARAM_INT);
    $stmt->bindParam(":usuarioActualizacion", $arrayAnio["usuarioActualizacion"], PDO::PARAM_INT);
    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  public static function mdlObtnerTodosLosAlumnosDeUnGradoCurso($tabla, $idCursoCerrar, $idGradoCerrar)
  {
    $stmt = Connection::conn()->prepare("SELECT
      alumno_anio_escolar.idAlumnoAnioEscolar
      FROM
        $tabla
        INNER JOIN
        grado
        ON 
          alumno_anio_escolar.idGrado = grado.idGrado
        INNER JOIN
        curso_grado
        ON 
          grado.idGrado = curso_grado.idGrado
        INNER JOIN
        curso
        ON 
          curso_grado.idCurso = curso.idCurso
      WHERE
        curso_grado.idCurso = :idCurso AND
        grado.idGrado = :idGrado");
    $stmt->bindParam(":idCurso", $idCursoCerrar, PDO::PARAM_INT);
    $stmt->bindParam(":idGrado", $idGradoCerrar, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}