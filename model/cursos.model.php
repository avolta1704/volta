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
    $tablaCursoGrado = "curso_grado";
    $tablaGrado = "grado";
    $stmt = Connection::conn()->prepare("SELECT c.descripcionCurso, c.idCurso, a.descripcionArea, g.descripcionGrado, c.estadoCurso
                FROM $tabla c 
                INNER JOIN $tablaArea a ON c.idArea = a.idArea
                INNER JOIN $tablaCursoGrado cg ON c.idCurso = cg.idCurso
                INNER JOIN $tablaGrado g ON cg.idGrado = g.idGrado
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
}
