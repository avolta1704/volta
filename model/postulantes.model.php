<?php
require_once "connection.php";

class ModelPostulantes
{
  //  Obtener todos los postulantes
  public static function mdlGetAllPostulantes($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT postulante.idPostulante, postulante.nombrePostulante, postulante.apellidoPostulante, postulante.dniPostulante, postulante.fechaPostulacion,
    CASE 
        WHEN postulante.gradoPostulacion = 1 THEN 'Inicial 3 Años'
        WHEN postulante.gradoPostulacion = 2 THEN 'Inicial 4 Años'
        WHEN postulante.gradoPostulacion = 3 THEN 'Inicial 5 Años'
        WHEN postulante.gradoPostulacion = 4 THEN 'Primaria 1er Grado'
        WHEN postulante.gradoPostulacion = 5 THEN 'Primaria 2do Grado'
        WHEN postulante.gradoPostulacion = 6 THEN 'Primaria 3er Grado'
        WHEN postulante.gradoPostulacion = 7 THEN 'Primaria 4to Grado'
        WHEN postulante.gradoPostulacion = 8 THEN 'Primaria 5to Grado'
        WHEN postulante.gradoPostulacion = 9 THEN 'Primaria 6to Grado'
        WHEN postulante.gradoPostulacion = 10 THEN 'Secundaria 1er Año'
        WHEN postulante.gradoPostulacion = 11 THEN 'Secundaria 2do Año'
        WHEN postulante.gradoPostulacion = 12 THEN 'Secundaria 3er Año'
        WHEN postulante.gradoPostulacion = 13 THEN 'Secundaria 4to Año'
        WHEN postulante.gradoPostulacion = 14 THEN 'Secundaria 5to Año'
        ELSE 'Sin Grado'
    END AS descripcionGrado,
    postulante.estadoPostulante 
    FROM $tabla 
    ORDER BY postulante.idPostulante DESC");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  //  Crear postulante
  public static function mdlCrearPostulante($tabla, $datosPostulante)
  {
    $statement = Connection::conn()->prepare("INSERT INTO $tabla (nombrePostulante, apellidoPostulante, dniPostulante, fechaPostulacion, fechaNacimiento, gradoPostulacion, estadoPostulante, fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion) VALUES (:nombrePostulante, :apellidoPostulante, :dniPostulante, :fechaPostulacion, :fechaNacimiento, :gradoPostulacion, :estadoPostulante, :fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion)");
    $statement->bindParam(":nombrePostulante", $datosPostulante["nombrePostulante"], PDO::PARAM_STR);
    $statement->bindParam(":apellidoPostulante", $datosPostulante["apellidoPostulante"], PDO::PARAM_STR);
    $statement->bindParam(":dniPostulante", $datosPostulante["dniPostulante"], PDO::PARAM_STR);
    $statement->bindParam(":fechaPostulacion", $datosPostulante["fechaPostulacion"], PDO::PARAM_STR);
    $statement->bindParam(":fechaNacimiento", $datosPostulante["fechaNacimiento"], PDO::PARAM_STR);
    $statement->bindParam(":gradoPostulacion", $datosPostulante["gradoPostulacion"], PDO::PARAM_INT);
    $statement->bindParam(":estadoPostulante", $datosPostulante["estadoPostulante"], PDO::PARAM_INT);
    $statement->bindParam(":fechaCreacion", $datosPostulante["fechaCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":fechaActualizacion", $datosPostulante["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioCreacion", $datosPostulante["usuarioCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioActualizacion", $datosPostulante["usuarioActualizacion"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  //  Eliminar postulante
  public static function mdlBorrarPostulante($tabla, $codPostulante)
  {
    $statement = Connection::conn()->prepare("DELETE FROM $tabla WHERE idPostulante = :idPostulante");
    $statement->bindParam(":idPostulante", $codPostulante, PDO::PARAM_INT);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  //  Obtener postulante por id
  public static function mdlGetPostulanteById($tabla, $codPostulante)
  {
    $statement = Connection::conn()->prepare("SELECT postulante.nombrePostulante, postulante.apellidoPostulante, postulante.dniPostulante, postulante.fechaPostulacion, postulante.fechaNacimiento, grado.idGrado, grado.descripcionGrado, nivel.idNivel, nivel.descripcionNivel FROM $tabla INNER JOIN grado ON postulante.gradoPostulacion = grado.idGrado INNER JOIN nivel ON grado.idNivel = nivel.idNivel WHERE idPostulante = :idPostulante");
    $statement->bindParam(":idPostulante", $codPostulante, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch();
  }

  //  Editar postulante
  public static function mdlEditarPostulante($tabla, $datosPostulante)
  {
    $statement = Connection::conn()->prepare("UPDATE $tabla SET nombrePostulante = :nombrePostulante, apellidoPostulante = :apellidoPostulante, dniPostulante = :dniPostulante, fechaPostulacion = :fechaPostulacion, fechaNacimiento = :fechaNacimiento, gradoPostulacion = :gradoPostulacion, fechaActualizacion = :fechaActualizacion, usuarioActualizacion = :usuarioActualizacion WHERE idPostulante = :idPostulante");
    $statement->bindParam(":nombrePostulante", $datosPostulante["nombrePostulante"], PDO::PARAM_STR);
    $statement->bindParam(":apellidoPostulante", $datosPostulante["apellidoPostulante"], PDO::PARAM_STR);
    $statement->bindParam(":dniPostulante", $datosPostulante["dniPostulante"], PDO::PARAM_STR);
    $statement->bindParam(":fechaPostulacion", $datosPostulante["fechaPostulacion"], PDO::PARAM_STR);
    $statement->bindParam(":fechaNacimiento", $datosPostulante["fechaNacimiento"], PDO::PARAM_STR);
    $statement->bindParam(":gradoPostulacion", $datosPostulante["gradoPostulacion"], PDO::PARAM_STR);
    $statement->bindParam(":fechaActualizacion", $datosPostulante["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioActualizacion", $datosPostulante["usuarioActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":idPostulante", $datosPostulante["idPostulante"], PDO::PARAM_STR);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  //  Obtener estado del postulante
  public static function mdlObtenerEstadoPostulante($tabla, $codPostulante)
  {
    $statement = Connection::conn()->prepare("SELECT estadoPostulante FROM $tabla WHERE idPostulante = :idPostulante");
    $statement->bindParam(":idPostulante", $codPostulante, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }

  //  Actualizar el estado de un postulante, en el caso que este como presentado se cambia a en revisión
  public static function mdlActualizarEstadoPostulante($tabla, $dataPostulanteEdit)
  {
    $statement = Connection::conn()->prepare("UPDATE $tabla SET estadoPostulante = :estadoPostulante,fechaActualizacion = :fechaActualizacion WHERE idPostulante = :idPostulante");
    $statement->bindParam(":estadoPostulante", $dataPostulanteEdit["estadoPostulante"], PDO::PARAM_INT);
    $statement->bindParam(":idPostulante", $dataPostulanteEdit["idPostulante"], PDO::PARAM_INT);
    $statement->bindParam(":fechaActualizacion", $dataPostulanteEdit["fechaActualizacion"], PDO::PARAM_INT);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
}
