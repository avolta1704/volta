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
}
