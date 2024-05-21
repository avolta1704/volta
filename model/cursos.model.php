<?php
require_once "connection.php";

class ModelCursos
{
  /**
   * Obtiene los cursos y concatenando los datos de las id correspondientes con las tablas relacionadas.
   *
   * @return array Retorna un array con los cursos.
   */
  static public function mdlGetCursos()
  {
    $tabla = "curso";
    $tablaArea = "area";
    $stmt = Connection::conn()->prepare("SELECT c.descripcionCurso, c.idCurso, a.descripcionArea, c.estadoCurso
                FROM $tabla c 
                INNER JOIN $tablaArea a ON c.idArea = a.idArea
                ORDER BY c.idCurso DESC
                ");
    $stmt->execute();
    return $stmt->fetchAll();
  }

  /**
   * Verifica si un Area está en uso en un curso .
   *
   * @return string ok si existe o error si no es el caso.
   */
  static public function mdlExistAreaEnCurso($idArea)
  {
    $tabla = "curso";
    $stmt = Connection::conn()->prepare("SELECT idCurso FROM $tabla WHERE idArea = :idArea");
    $stmt->bindParam(":idArea", $idArea, PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      return "ok";
    } else {
      return "error";
    }
  }

  /**
   * Registra un curso.
   *
   * @param array $data Datos del curso.
   * @return string Retorna un mensaje de éxito o error.
   */
  static public function mdlRegistrarCurso($data)
  {
    $tabla = "curso";
    $stmt = Connection::conn()->prepare("INSERT INTO $tabla(descripcionCurso, idArea, fechaActualizacion, usuarioActualizacion, fechaCreacion, usuarioCreacion, estadoCurso) VALUES (:descripcionCurso, :idArea, :fechaActualizacion, :usuarioActualizacion, :fechaCreacion, :usuarioCreacion,  1)");
    $stmt->bindParam(":descripcionCurso", $data["descripcionCurso"], PDO::PARAM_STR);
    $stmt->bindParam(":idArea", $data["idArea"], PDO::PARAM_INT);
    $stmt->bindParam(":fechaActualizacion", $data["fechaActualizacion"], PDO::PARAM_STR);
    $stmt->bindParam(":usuarioActualizacion", $data["usuarioActualizacion"], PDO::PARAM_INT);
    $stmt->bindParam(":fechaCreacion", $data["fechaCreacion"], PDO::PARAM_STR);
    $stmt->bindParam(":usuarioCreacion", $data["usuarioCreacion"], PDO::PARAM_INT);
    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  /**
   * Elimina un curso.
   *
   * @param int $idCurso El ID del curso.
   * @return string Retorna un mensaje de éxito o error.
   */
  static public function mdlEliminarCurso($idCurso)
  {
    $tabla = "curso";
    $stmt = Connection::conn()->prepare("DELETE FROM $tabla WHERE idCurso = :idCurso");
    $stmt->bindParam(":idCurso", $idCurso, PDO::PARAM_INT);
    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  /**
   * Verifica si un curso está en uso en un curso grado.
   *
   * @return string ok si existe o error si no es el caso.
   */
  static public function mdlExisteCursoEnCursoGrado($idCurso)
  {
    $tabla = "curso_grado";
    $stmt = Connection::conn()->prepare("SELECT idCursoGrado FROM $tabla WHERE idCurso = :idCurso");
    $stmt->bindParam(":idCurso", $idCurso, PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      return "ok";
    } else {
      return "error";
    }
  }
}
