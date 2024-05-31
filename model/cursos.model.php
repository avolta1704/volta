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
    $stmt = Connection::conn()->prepare("INSERT INTO $tabla(descripcionCurso, idArea, fechaActualizacion, usuarioActualizacion, fechaCreacion, usuarioCreacion, estadoCurso) VALUES (:descripcionCurso, :idArea, :fechaActualizacion, :usuarioActualizacion, :fechaCreacion, :usuarioCreacion,  :estadoCurso)");
    $stmt->bindParam(":descripcionCurso", $data["descripcionCurso"], PDO::PARAM_STR);
    $stmt->bindParam(":idArea", $data["idArea"], PDO::PARAM_INT);
    $stmt->bindParam(":estadoCurso", $data["estadoCurso"], PDO::PARAM_INT);
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

  /**
   * Obtiene un curso.
   *
   * @param int $idCurso El ID del curso a obtener.
   * @return array Retorna un array con los datos del curso.
   */
  static public function mdlGetCurso($idCurso)
  {
    $tabla = "curso";
    $stmt = Connection::conn()->prepare("SELECT idCurso, descripcionCurso, idArea, estadoCurso FROM $tabla WHERE idCurso = :idCurso");
    $stmt->bindParam(":idCurso", $idCurso, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch();
  }

  /**
   * Edita un curso.
   *
   * @param array $data Datos del curso.
   * @return string Retorna un mensaje de éxito o error.
   */

  static public function mdlEditarCurso($data)
  {
    $tabla = "curso";
    $stmt = Connection::conn()->prepare("UPDATE $tabla SET descripcionCurso = :descripcionCurso, idArea = :idArea, estadoCurso = :estadoCurso, fechaActualizacion = :fechaActualizacion, usuarioActualizacion = :usuarioActualizacion WHERE idCurso = :idCurso");
    $stmt->bindParam(":descripcionCurso", $data["descripcionCurso"], PDO::PARAM_STR);
    $stmt->bindParam(":idArea", $data["idArea"], PDO::PARAM_INT);
    $stmt->bindParam(":estadoCurso", $data["estadoCurso"], PDO::PARAM_INT);
    $stmt->bindParam(":fechaActualizacion", $data["fechaActualizacion"], PDO::PARAM_STR);
    $stmt->bindParam(":usuarioActualizacion", $data["usuarioActualizacion"], PDO::PARAM_INT);
    $stmt->bindParam(":idCurso", $data["idCurso"], PDO::PARAM_INT);
    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  /**
   * Obtiene los grados por nivel.
   *
   * @return array Retorna un array con los grados.
   */
  static public function mdlGetGradosPorNivel()
  {
    $tabla = "grado";
    $tablaNivel = "nivel";
    $stmt = Connection::conn()->prepare("SELECT g.idGrado, g.descripcionGrado, n.descripcionNivel
          FROM $tabla g 
          INNER JOIN $tablaNivel n ON g.idNivel = n.idNivel
          ORDER BY g.idNivel ASC, g.idGrado ASC 
          ");
    $stmt->execute();
    return $stmt->fetchAll();
  }

  /**
   * Obtiene los cursos por grado.
   *
   * @param int $idGrado El ID del grado.
   * @return array Retorna un array con los cursos.
   */
  static public function mdlGetCursosPorGrado($idGrado)
  {
    $tabla = "curso_grado";
    $tablaCurso = "curso";
    $stmt = Connection::conn()->prepare("SELECT cg.idCursoGrado, cg.idCurso, c.descripcionCurso, cg.idGrado
          FROM $tabla cg 
          INNER JOIN $tablaCurso c ON cg.idCurso = c.idCurso
          WHERE cg.idGrado = :idGrado
          ORDER BY c.descripcionCurso ASC
          ");
    $stmt->bindParam(":idGrado", $idGrado, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  /**
   * Obtiene los cursos sin asignar por grado.
   *
   * @param int $idGrado El ID del grado.
   * @return array Retorna un array con los cursos.
   */
  static public function mdlGetCursosSinAsignar($idGrado)
  {
    $tabla = "curso";
    $stmt = Connection::conn()->prepare("SELECT c.idCurso, c.descripcionCurso
          FROM $tabla c
          WHERE c.idCurso NOT IN (SELECT idCurso FROM curso_grado WHERE idGrado = :idGrado)
          ORDER BY c.descripcionCurso ASC
          ");
    $stmt->bindParam(":idGrado", $idGrado, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  /**
   * Asigna un curso a un grado.
   *
   * @param array $data Datos de la asignación.
   * @return string Retorna un mensaje de éxito o error.
   */
  static public function mdlAsignarCursoAGrado($data)
  {
    $tabla = "curso_grado";
    $stmt = Connection::conn()->prepare("INSERT INTO $tabla (idCurso, idGrado, fechaCreacion, usuarioCreacion, fechaActualizacion, usuarioActualizacion) VALUES (:idCurso, :idGrado, :fechaCreacion, :usuarioCreacion, :fechaActualizacion, :usuarioActualizacion)");
    $stmt->bindParam(":idCurso", $data["idCurso"], PDO::PARAM_INT);
    $stmt->bindParam(":idGrado", $data["idGrado"], PDO::PARAM_INT);
    $stmt->bindParam(":fechaCreacion", $data["fechaCreacion"], PDO::PARAM_STR);
    $stmt->bindParam(":usuarioCreacion", $data["usuarioCreacion"], PDO::PARAM_INT);
    $stmt->bindParam(":fechaActualizacion", $data["fechaActualizacion"], PDO::PARAM_STR);
    $stmt->bindParam(":usuarioActualizacion", $data["usuarioActualizacion"], PDO::PARAM_INT);
    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  /**
   * Elimina un curso asignado a un grado.
   *
   * @param int $idCursoGrado El ID del curso asignado.
   * @return string Retorna un mensaje de éxito o error.
   */
  static public function mdlEliminarCursoGrado($idCursoGrado)
  {
    $tabla = "curso_grado";
    $stmt = Connection::conn()->prepare("DELETE FROM $tabla WHERE idCursoGrado = :idCursoGrado");
    $stmt->bindParam(":idCursoGrado", $idCursoGrado, PDO::PARAM_INT);
    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  static public function mdlObtenerUltimoIdCreado()
  {
    $tabla = "curso_grado";
    $statement = Connection::conn()->prepare("SELECT idCursoGrado FROM curso_grado ORDER BY fechaCreacion DESC LIMIT 1");
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result['idCursoGrado'];
    
  }
}
