<?php
require_once "connection.php";
class ModelDocentes
{
  //  Obtener todos los usuarios
  public static function mdlGetAllDocentes($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT
    usuario.idUsuario, 
    usuario.nombreUsuario, 
    usuario.apellidoUsuario, 
    usuario.estadoUsuario, 
    tipo_usuario.descripcionTipoUsuario, 
		tipo_usuario.idTipoUsuario,
    personal.idPersonal, 
    tipo_personal.descripcionTipo,
    personal.idTipoPersonal
  FROM
    $tabla
    INNER JOIN
    tipo_usuario
    ON 
      usuario.idTipoUsuario = tipo_usuario.idTipoUsuario
    INNER JOIN
    personal
    ON 
      usuario.idUsuario = personal.idUsuario
    INNER JOIN
    tipo_personal
    ON 
      personal.idTipoPersonal = tipo_personal.idTipoPersonal
  WHERE
    usuario.idTipoUsuario = 2
  ORDER BY
    usuario.idUsuario DESC");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  //  Obtener tipo de usuarios
  public static function mdlGetTipoUsuarios($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT tipo_usuario.idTipoUsuario, tipo_usuario.descripcionTipoUsuario FROM $tabla");
    $statement->execute();
    return $statement->fetchAll();
  }

  //  Obtener grados
  public static function mdlGetCursoGrado($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT
    grado.descripcionGrado, 
    nivel.descripcionNivel
  FROM
    grado
    INNER JOIN
    nivel
    ON 
      grado.idNivel = nivel.idNivel");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  //  Obtener descripion grado
  public static function mdlGetGrado($tabla, $idpersonal)
  {
    $statement = Connection::conn()->prepare("SELECT
      grado.descripcionGrado
    FROM
      usuario
      INNER JOIN
      personal
      ON 
        usuario.idUsuario = personal.idUsuario
      INNER JOIN
      cursogrado_personal
      ON 
        personal.idPersonal = cursogrado_personal.idPersonal
      INNER JOIN
      curso_grado
      ON 
        cursogrado_personal.idCursoGrado = curso_grado.idCursoGrado
      INNER JOIN
      grado
      ON 
        grado.idGrado = curso_grado.idGrado
    WHERE
      cursogrado_personal.idPersonal = :idPersonal");
    $statement->bindParam(":idPersonal", $idpersonal, PDO::PARAM_STR);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  //  Obtener cursos
  public static function mdlGetCurso($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT
      grado.descripcionGrado, 
      nivel.idNivel, 
      curso.descripcionCurso,
      grado.idGrado
    FROM
      grado
      INNER JOIN
      nivel
      ON 
        grado.idNivel = nivel.idNivel
      INNER JOIN
      curso
      INNER JOIN
      curso_grado
      ON 
        curso.idCurso = curso_grado.idCurso AND
        grado.idGrado = curso_grado.idGrado");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  //  Cambiar estado del alumno
  public static function mdlobtenerIdCursogrado($tabla, $gradoSeleccionado, $cursoSeleccionado)
  {
    $statement = Connection::conn()->prepare("SELECT
    curso_grado.idCursoGrado
  FROM
    $tabla
    INNER JOIN
    curso
    ON 
      curso_grado.idCurso = curso.idCurso
    INNER JOIN
    grado
    ON 
      curso_grado.idGrado = grado.idGrado
  WHERE
    curso.descripcionCurso = :cursoSeleccionado AND
    grado.descripcionGrado = :descripcionGrado");
    $statement->bindParam(":descripcionGrado", $gradoSeleccionado, PDO::PARAM_STR);
    $statement->bindParam(":cursoSeleccionado", $cursoSeleccionado, PDO::PARAM_STR);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }


  //  Insertar en la tabla cursogrado_personal
  public static function mdlAsignarCurso($table, $dataCursoGradoPersonal)
  {
    $statement = Connection::conn()->prepare("INSERT INTO $table (idCursoGrado, idPersonal, fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion) VALUES (:idCursoGrado, :idPersonal, :fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion)");
    $statement->bindParam(":idCursoGrado", $dataCursoGradoPersonal["idCursoGrado"], PDO::PARAM_INT);
    $statement->bindParam(":idPersonal", $dataCursoGradoPersonal["idPersonal"], PDO::PARAM_INT);
    $statement->bindParam(":fechaCreacion", $dataCursoGradoPersonal["fechaCreacion"], PDO::PARAM_INT);
    $statement->bindParam(":fechaActualizacion", $dataCursoGradoPersonal["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioCreacion", $dataCursoGradoPersonal["usuarioCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioActualizacion", $dataCursoGradoPersonal["usuarioActualizacion"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  //  Obtener Cursos ID
  public static function mdlObteneridCursos($table, $gradoSeleccionado)
  {
    $statement = Connection::conn()->prepare("SELECT
    curso_grado.idCursoGrado
  FROM
    $table
    INNER JOIN
    curso
    ON 
      curso_grado.idCurso = curso.idCurso
    INNER JOIN
    grado
    ON 
      curso_grado.idGrado = grado.idGrado
  WHERE
    grado.descripcionGrado = :descripcionGrado");
    $statement->bindParam(":descripcionGrado", $gradoSeleccionado);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  //  Obtener id Personal de curso ya asignado
  public static function mdlObteneridPersonal($tabla, $gradoSeleccionado, $cursoSeleccionado)
  {
    $statement = Connection::conn()->prepare("SELECT
      cursogrado_personal.idPersonal,
      cursogrado_personal.idCursoGrado
    FROM
      $tabla
      INNER JOIN
      curso_grado
      ON 
        cursogrado_personal.idCursoGrado = curso_grado.idCursoGrado
      INNER JOIN
      curso
      ON 
        curso_grado.idCurso = curso.idCurso
      INNER JOIN
      grado
      ON 
        curso_grado.idGrado = grado.idGrado
    WHERE
      curso.descripcionCurso = :cursoSeleccionado AND
      grado.descripcionGrado = :descripcionGrado");
    $statement->bindParam(":descripcionGrado", $gradoSeleccionado, PDO::PARAM_STR);
    $statement->bindParam(":cursoSeleccionado", $cursoSeleccionado, PDO::PARAM_STR);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }

  //  Modificar Personal
  public static function mdlCambiarIdPersonal($table, $idPersonalRepetido, $idPersonalReemplazo, $idcursogradoRepetido)
  {
    $statement = Connection::conn()->prepare("UPDATE cursogrado_personal
    SET idPersonal = :idPersonalReemplazo
    WHERE 
      idPersonal = :idPersonalRepetido AND 
      idCursoGrado = :idCursoGradoRepetido;");
    $statement->bindParam(":idPersonalRepetido", $idPersonalRepetido, PDO::PARAM_STR);
    $statement->bindParam(":idPersonalReemplazo", $idPersonalReemplazo, PDO::PARAM_STR);
    $statement->bindParam(":idCursoGradoRepetido", $idcursogradoRepetido, PDO::PARAM_STR);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  //  Cambiar estado del docente
  public static function mdlCambiarEstadoDocente($tabla, $idUsuarioEstado, $cambiarEstadoDocente)
  {
    $statement = Connection::conn()->prepare("UPDATE $tabla SET estadoUsuario=:estadoDocente WHERE idUsuario=:idDocente");
    $statement->bindParam(":idDocente", $idUsuarioEstado, PDO::PARAM_STR);
    $statement->bindParam(":estadoDocente", $cambiarEstadoDocente, PDO::PARAM_STR);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  /**
   * Obtener el idDocente por idUsuario
   * 
   * @param int $idUsuario ID del usuario
   * @return int $idPersonal ID del docente
   */
  public static function mdlObtenerIdPersonalByIdUsuario($idUsuario)
  {
    $statement = Connection::conn()->prepare("SELECT idPersonal FROM personal WHERE idUsuario = :idUsuario");
    $statement->bindParam(":idUsuario", $idUsuario, PDO::PARAM_STR);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC)["idPersonal"];
  }

  /**
   * Obtener los cursos asignados al docente
   * 
   * @param int $idPersonal ID del docente
   * @return array $response Array con los cursos asignados al docente
   */
  public static function mdlObtenerCursosAsignados($idPersonal)
  {
    $statement = Connection::conn()->prepare("SELECT    
    c.descripcionCurso,
    g.descripcionGrado,
    cgp.idPersonal,
    cg.idCurso,
    g.idGrado
  FROM
    cursogrado_personal as cgp
    INNER JOIN
    curso_grado as cg
    ON 
      cgp.idCursoGrado = cg.idCursoGrado
    INNER JOIN
    curso as c
    ON 
      cg.idCurso = c.idCurso
    INNER JOIN
    grado as g
    ON 
      cg.idGrado = g.idGrado
  WHERE
    cgp.idPersonal = :idPersonal");
    $statement->bindParam(":idPersonal", $idPersonal, PDO::PARAM_STR);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
}
